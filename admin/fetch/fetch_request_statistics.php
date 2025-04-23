<?php
include('../../function/db.php');

// Function to calculate average response time with service type breakdown
function calculateAverageResponseTime($con) {
    $query = "SELECT 
                service_type,
                AVG(TIMESTAMPDIFF(HOUR, request_date, 
                    CASE 
                        WHEN status = 'Completed' THEN completed_date
                        WHEN status = 'Cancelled' THEN cancelled_date
                        ELSE NOW()
                    END)) as avg_response_time
              FROM service_request 
              WHERE request_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
              GROUP BY service_type";
    
    $result = mysqli_query($con, $query);
    $responseTimesByType = [];
    $totalAvg = 0;
    $count = 0;
    
    while($row = mysqli_fetch_assoc($result)) {
        $responseTimesByType[$row['service_type']] = round($row['avg_response_time'], 1);
        $totalAvg += $row['avg_response_time'];
        $count++;
    }
    
    return [
        'overall' => $count > 0 ? round($totalAvg / $count, 1) : 0,
        'by_type' => $responseTimesByType
    ];
}

// Function to calculate completion rate with detailed breakdown
function calculateCompletionRate($con) {
    $query = "SELECT 
                COUNT(*) as total_requests,
                SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_requests,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_requests,
                SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as in_progress_requests,
                SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_requests,
                service_type
              FROM service_request 
              WHERE request_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
              GROUP BY service_type";
    
    $result = mysqli_query($con, $query);
    $completionStats = [
        'overall' => 0,
        'by_type' => [],
        'status_breakdown' => [
            'pending' => 0,
            'in_progress' => 0,
            'completed' => 0,
            'cancelled' => 0
        ]
    ];
    
    $totalRequests = 0;
    $totalCompleted = 0;
    
    while($row = mysqli_fetch_assoc($result)) {
        $rate = $row['total_requests'] > 0 ? 
            round(($row['completed_requests'] / $row['total_requests']) * 100, 1) : 0;
        
        $completionStats['by_type'][$row['service_type']] = [
            'rate' => $rate,
            'total' => $row['total_requests'],
            'completed' => $row['completed_requests']
        ];
        
        $totalRequests += $row['total_requests'];
        $totalCompleted += $row['completed_requests'];
        
        // Update status breakdown
        $completionStats['status_breakdown']['pending'] += $row['pending_requests'];
        $completionStats['status_breakdown']['in_progress'] += $row['in_progress_requests'];
        $completionStats['status_breakdown']['completed'] += $row['completed_requests'];
        $completionStats['status_breakdown']['cancelled'] += $row['cancelled_requests'];
    }
    
    $completionStats['overall'] = $totalRequests > 0 ? 
        round(($totalCompleted / $totalRequests) * 100, 1) : 0;
    
    return $completionStats;
}

// Function to get monthly requests count with additional metrics
function getMonthlyRequestsCount($con) {
    $query = "SELECT 
                COUNT(*) as monthly_count,
                service_type,
                AVG(participants) as avg_participants,
                SUM(payment_amount) as total_revenue,
                COUNT(DISTINCT user_id) as unique_clients
              FROM service_request 
              WHERE request_date >= DATE_FORMAT(NOW(), '%Y-%m-01')
              GROUP BY service_type";
    
    $result = mysqli_query($con, $query);
    $monthlyStats = [
        'total' => 0,
        'by_type' => [],
        'total_revenue' => 0,
        'unique_clients' => 0,
        'avg_participants' => 0
    ];
    
    $totalParticipants = 0;
    $serviceTypes = 0;
    
    while($row = mysqli_fetch_assoc($result)) {
        $monthlyStats['by_type'][$row['service_type']] = [
            'count' => $row['monthly_count'],
            'avg_participants' => round($row['avg_participants'], 1),
            'revenue' => $row['total_revenue']
        ];
        
        $monthlyStats['total'] += $row['monthly_count'];
        $monthlyStats['total_revenue'] += $row['total_revenue'];
        $monthlyStats['unique_clients'] = max($monthlyStats['unique_clients'], $row['unique_clients']);
        $totalParticipants += $row['avg_participants'];
        $serviceTypes++;
    }
    
    $monthlyStats['avg_participants'] = $serviceTypes > 0 ? 
        round($totalParticipants / $serviceTypes, 1) : 0;
    
    return $monthlyStats;
}

// Function to get overdue requests count with priority levels
function getOverdueRequestsCount($con) {
    $query = "SELECT 
                COUNT(*) as overdue_count,
                service_type,
                DATEDIFF(NOW(), request_date) as days_overdue
              FROM service_request 
              WHERE status = 'Pending' 
              AND request_date <= DATE_SUB(NOW(), INTERVAL 48 HOUR)
              GROUP BY service_type, 
                CASE 
                    WHEN DATEDIFF(NOW(), request_date) > 7 THEN 'critical'
                    WHEN DATEDIFF(NOW(), request_date) > 3 THEN 'high'
                    ELSE 'medium'
                END";
    
    $result = mysqli_query($con, $query);
    $overdueStats = [
        'total' => 0,
        'by_type' => [],
        'by_priority' => [
            'critical' => 0,
            'high' => 0,
            'medium' => 0
        ]
    ];
    
    while($row = mysqli_fetch_assoc($result)) {
        $overdueStats['by_type'][$row['service_type']] = $row['overdue_count'];
        $overdueStats['total'] += $row['overdue_count'];
        
        // Categorize by priority based on days overdue
        if($row['days_overdue'] > 7) {
            $overdueStats['by_priority']['critical'] += $row['overdue_count'];
        } elseif($row['days_overdue'] > 3) {
            $overdueStats['by_priority']['high'] += $row['overdue_count'];
        } else {
            $overdueStats['by_priority']['medium'] += $row['overdue_count'];
        }
    }
    
    return $overdueStats;
}

// Function to calculate trends with enhanced metrics
function calculateTrends($con) {
    $trends = [];
    
    // Current month's metrics
    $currentMonth = [
        'avg_response_time' => calculateAverageResponseTime($con)['overall'],
        'completion_rate' => calculateCompletionRate($con)['overall'],
        'monthly_requests' => getMonthlyRequestsCount($con)['total'],
        'revenue' => getMonthlyRequestsCount($con)['total_revenue']
    ];
    
    // Last month's metrics
    $lastMonthQuery = "SELECT 
        COUNT(*) as total_requests,
        SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_requests,
        AVG(TIMESTAMPDIFF(HOUR, request_date, 
            CASE 
                WHEN status = 'Completed' THEN completed_date
                WHEN status = 'Cancelled' THEN cancelled_date
                ELSE NOW()
            END)) as avg_response_time,
        SUM(payment_amount) as total_revenue
        FROM service_request 
        WHERE request_date BETWEEN DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-01'), INTERVAL 1 MONTH)
        AND DATE_FORMAT(NOW(), '%Y-%m-01')";
    
    $result = mysqli_query($con, $lastMonthQuery);
    $lastMonth = mysqli_fetch_assoc($result);
    
    // Calculate trends
    $trends['average response time'] = $lastMonth['avg_response_time'] > 0 ? 
        round((($currentMonth['avg_response_time'] - $lastMonth['avg_response_time']) / $lastMonth['avg_response_time']) * 100, 1) : 0;
    
    $lastMonthCompletionRate = $lastMonth['total_requests'] > 0 ? 
        ($lastMonth['completed_requests'] / $lastMonth['total_requests']) * 100 : 0;
    $trends['completion rate'] = $lastMonthCompletionRate > 0 ? 
        round((($currentMonth['completion_rate'] - $lastMonthCompletionRate) / $lastMonthCompletionRate) * 100, 1) : 0;
    
    $trends['total requests this month'] = $lastMonth['total_requests'] > 0 ? 
        round((($currentMonth['monthly_requests'] - $lastMonth['total_requests']) / $lastMonth['total_requests']) * 100, 1) : 0;
    
    $trends['revenue'] = $lastMonth['total_revenue'] > 0 ? 
        round((($currentMonth['revenue'] - $lastMonth['total_revenue']) / $lastMonth['total_revenue']) * 100, 1) : 0;
    
    return $trends;
}

// Main execution
try {
    $response = [
        'success' => true,
        'data' => [
            'avgResponseTime' => calculateAverageResponseTime($con),
            'completionRate' => calculateCompletionRate($con),
            'monthlyRequests' => getMonthlyRequestsCount($con),
            'overdueRequests' => getOverdueRequestsCount($con),
            'trends' => calculateTrends($con)
        ]
    ];
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => 'Error fetching statistics: ' . $e->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?> 