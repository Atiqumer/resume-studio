<?php
function renderTemplate2($data, $forPdf = false) {
    $personal = $data['personal_info'] ?? [];
    $experience = $data['experience'] ?? [];
    $education = $data['education'] ?? [];
    $skills = $data['skills'] ?? [];
    
    if ($forPdf) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <style>
                body { 
                    font-family: DejaVu Sans, Arial, sans-serif; 
                    color: #333;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                }
                .header { 
                    background: #2c3e50;
                    color: white;
                    padding: 30px;
                    margin-bottom: 20px;
                }
                .name { 
                    font-size: 28px; 
                    font-weight: bold; 
                    margin-bottom: 10px;
                }
                .contact-info { 
                    font-size: 12px;
                }
                .contact-info span { 
                    margin: 0 10px;
                }
                .container {
                    display: block;
                    padding: 0 30px;
                }
                .main-content {
                    width: 70%;
                    float: left;
                }
                .sidebar {
                    width: 28%;
                    float: right;
                }
                .section { 
                    margin-bottom: 20px;
                }
                .section-title { 
                    font-size: 16px; 
                    font-weight: bold; 
                    color: #2c3e50;
                    border-left: 4px solid #308ce8;
                    padding-left: 10px;
                    margin-bottom: 15px;
                }
                .experience-item, .education-item { 
                    margin-bottom: 15px;
                }
                .job-title { 
                    font-weight: bold; 
                    font-size: 14px;
                    color: #2c3e50;
                }
                .company { 
                    color: #308ce8; 
                    font-size: 12px;
                    margin-bottom: 5px;
                }
                .description { 
                    font-size: 12px; 
                    margin-top: 5px;
                    color: #666;
                }
                .sidebar-section {
                    margin-bottom: 20px;
                }
                .sidebar-title {
                    font-size: 14px;
                    font-weight: bold;
                    color: #2c3e50;
                    margin-bottom: 8px;
                }
                .sidebar-content {
                    font-size: 12px;
                    color: #666;
                    line-height: 1.5;
                }
                .skill-item {
                    margin-bottom: 4px;
                    font-size: 12px;
                }
                .clear {
                    clear: both;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="name"><?= htmlspecialchars($personal['full_name'] ?? 'Your Name') ?></div>
                <div class="contact-info">
                    <?= htmlspecialchars($personal['email'] ?? 'email@example.com') ?>
                    <span>|</span>
                    <?= htmlspecialchars($personal['phone'] ?? '(123) 456-7890') ?>
                    <?php if (!empty($personal['linkedin'])): ?>
                        <span>|</span>
                        <?= htmlspecialchars($personal['linkedin']) ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="container">
                <div class="main-content">
                    <!-- Experience -->
                    <div class="section">
                        <div class="section-title">Professional Experience</div>
                        <?php if (!empty($experience)): ?>
                            <?php foreach ($experience as $exp): ?>
                                <div class="experience-item">
                                    <div class="job-title"><?= htmlspecialchars($exp['job_title'] ?? '') ?></div>
                                    <div class="company">
                                        <?= htmlspecialchars($exp['company'] ?? '') ?> | <?= htmlspecialchars($exp['duration'] ?? '') ?>
                                    </div>
                                    <div class="description"><?= nl2br(htmlspecialchars($exp['description'] ?? '')) ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="experience-item">
                                <div class="description">Your experience will appear here...</div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Education -->
                    <div class="section">
                        <div class="section-title">Education</div>
                        <?php if (!empty($education)): ?>
                            <?php foreach ($education as $edu): ?>
                                <div class="experience-item">
                                    <div class="job-title"><?= htmlspecialchars($edu['degree'] ?? '') ?></div>
                                    <div class="company">
                                        <?= htmlspecialchars($edu['institution'] ?? '') ?> | <?= htmlspecialchars($edu['year'] ?? '') ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="experience-item">
                                <div class="description">Your education will appear here...</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="sidebar">
                    <!-- Summary -->
                    <?php if (!empty($personal['summary'])): ?>
                    <div class="sidebar-section">
                        <div class="sidebar-title">About Me</div>
                        <div class="sidebar-content"><?= nl2br(htmlspecialchars($personal['summary'])) ?></div>
                    </div>
                    <?php endif; ?>

                    <!-- Skills -->
                    <?php if (!empty($skills)): ?>
                    <div class="sidebar-section">
                        <div class="sidebar-title">Skills</div>
                        <div class="sidebar-content">
                            <?php foreach ($skills as $skill): ?>
                                <div class="skill-item">• <?= htmlspecialchars($skill) ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="clear"></div>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Web version with Tailwind CSS
        ?>
        <div class="template2 bg-gray-50 p-8 text-gray-800 font-serif">
            <!-- Modern header with background -->
            <div class="bg-blue-800 text-white p-6 rounded-lg mb-8">
                <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($personal['full_name'] ?? 'Your Name') ?></h1>
                <div class="flex flex-wrap gap-4 text-sm">
                    <span><?= htmlspecialchars($personal['email'] ?? 'email@example.com') ?></span>
                    <span><?= htmlspecialchars($personal['phone'] ?? '(123) 456-7890') ?></span>
                    <?php if (!empty($personal['linkedin'])): ?>
                        <span><?= htmlspecialchars($personal['linkedin']) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2">
                    <!-- Experience -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-900 border-l-4 border-blue-600 pl-3 mb-4">Professional Experience</h2>
                        <?php if (!empty($experience)): ?>
                            <?php foreach ($experience as $exp): ?>
                                <div class="mb-4">
                                    <h3 class="font-bold text-lg text-gray-900"><?= htmlspecialchars($exp['job_title'] ?? '') ?></h3>
                                    <p class="text-sm text-blue-600 mb-1"><?= htmlspecialchars($exp['company'] ?? '') ?> | <?= htmlspecialchars($exp['duration'] ?? '') ?></p>
                                    <p class="text-sm text-gray-600 leading-relaxed"><?= nl2br(htmlspecialchars($exp['description'] ?? '')) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 italic">Your experience will appear here...</p>
                        <?php endif; ?>
                    </div>

                    <!-- Education -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-900 border-l-4 border-blue-600 pl-3 mb-4">Education</h2>
                        <?php if (!empty($education)): ?>
                            <?php foreach ($education as $edu): ?>
                                <div class="mb-3">
                                    <h3 class="font-bold text-gray-900"><?= htmlspecialchars($edu['degree'] ?? '') ?></h3>
                                    <p class="text-sm text-blue-600"><?= htmlspecialchars($edu['institution'] ?? '') ?> | <?= htmlspecialchars($edu['year'] ?? '') ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 italic">Your education will appear here...</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-1">
                    <!-- Summary -->
                    <?php if (!empty($personal['summary'])): ?>
                    <div class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-3">About Me</h2>
                        <p class="text-sm leading-relaxed text-gray-700"><?= nl2br(htmlspecialchars($personal['summary'])) ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Skills -->
                    <?php if (!empty($skills)): ?>
                    <div class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-3">Skills</h2>
                        <div class="space-y-2">
                            <?php foreach ($skills as $skill): ?>
                                <div class="text-sm text-gray-700">• <?= htmlspecialchars($skill) ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>