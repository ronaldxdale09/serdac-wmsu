<?php include('include/header.php'); ?>
<link rel="stylesheet" href="css/project_list.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<body>
    <?php include('include/navbar.php'); ?>
    
    <main class="container py-5">
        <h1 class="h3 font-weight-bold text-maroon mb-4">Research Projects</h1>
        
        <?php
        $results = mysqli_query($con, "SELECT * FROM repo_projects");
        ?>
        
        <div class="project-grid">
            <?php while($row = mysqli_fetch_assoc($results)): ?>
                <div class="project-card">
                    <div class="project-header">
                        <h2 class="project-title"><?= htmlspecialchars($row['ProjectTitle']) ?></h2>
                    </div>
                    <div class="project-body">
                        <div class="project-meta">
                            <div class="meta-item">
                                <i class="fas fa-user"></i>
                                <?= htmlspecialchars($row['ProjectLeader']) ?>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-building"></i>
                                <?= htmlspecialchars($row['ImplementingAgency']) ?>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <?= date('M Y', strtotime($row['ProjectDurationStart'])) ?>
                            </div>
                        </div>
                        
                        <?php if(!empty($row['ProjectAbstract'])): ?>
                            <p class="mb-3"><?= substr(htmlspecialchars($row['ProjectAbstract']), 0, 150) ?>...</p>
                        <?php endif; ?>
                        
                        <div class="project-card-bottom">
                            <span class="status-badge status-<?= strtolower($row['Status']) ?>">
                                <?= $row['Status'] ?>
                            </span>
                            <button class="view-btn" data-bs-toggle="modal" data-bs-target="#projectModal<?= $row['ProjectID'] ?>">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Project Modal -->
                <div class="modal fade project-modal" id="projectModal<?= $row['ProjectID'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= htmlspecialchars($row['ProjectTitle']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="detail-row">
                                    <div class="detail-label">Program Title:</div>
                                    <div class="detail-value"><?= htmlspecialchars($row['ProgramTitle']) ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Project Leader:</div>
                                    <div class="detail-value"><?= htmlspecialchars($row['ProjectLeader']) ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Implementing Agency:</div>
                                    <div class="detail-value"><?= htmlspecialchars($row['ImplementingAgency']) ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Duration:</div>
                                    <div class="detail-value">
                                        <?= date('M d, Y', strtotime($row['ProjectDurationStart'])) ?> - 
                                        <?= date('M d, Y', strtotime($row['ProjectDurationEnd'])) ?>
                                        <?php if($row['ExtensionDate']): ?>
                                            (Extended to <?= date('M d, Y', strtotime($row['ExtensionDate'])) ?>)
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Project Cost:</div>
                                    <div class="detail-value">₱<?= number_format($row['ProjectCost'], 2) ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Status:</div>
                                    <div class="detail-value">
                                        <span class="status-badge status-<?= strtolower($row['Status']) ?>">
                                            <?= $row['Status'] ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">SDG Addressed:</div>
                                    <div class="detail-value"><?= htmlspecialchars($row['SDGAddressed']) ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Funded By:</div>
                                    <div class="detail-value"><?= htmlspecialchars($row['FundedBy']) ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Facilitated By:</div>
                                    <div class="detail-value"><?= htmlspecialchars($row['FacilitatedBy']) ?></div>
                                </div>
                                
                                <div class="project-abstract">
                                    <h6>Project Abstract</h6>
                                    <p><?= nl2br(htmlspecialchars($row['ProjectAbstract'])) ?></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
        <div class="divider"></div>
    </main>

    <?php include('include/footer.php'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>