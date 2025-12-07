<?php
function renderTemplate1($data, $forPdf = false) {
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
                    padding: 20px;
                }
                .header { 
                    text-align: center; 
                    margin-bottom: 30px;
                    border-bottom: 2px solid #308ce8;
                    padding-bottom: 15px;
                }
                .name { 
                    font-size: 24px; 
                    font-weight: bold; 
                    color: #2c3e50;
                    margin-bottom: 8px;
                }
                .contact-info { 
                    font-size: 12px; 
                    color: #666;
                }
                .contact-info span { 
                    margin: 0 8px;
                }
                .section { 
                    margin-bottom: 20px;
                }
                .section-title { 
                    font-size: 16px; 
                    font-weight: bold; 
                    color: #308ce8;
                    border-bottom: 1px solid #308ce8;
                    padding-bottom: 5px;
                    margin-bottom: 10px;
                }
                .experience-item, .education-item { 
                    margin-bottom: 15px;
                }
                .job-title { 
                    font-weight: bold; 
                    font-size: 14px;
                }
                .company, .institution { 
                    color: #666; 
                    font-size: 12px;
                    margin-bottom: 5px;
                }
                .duration { 
                    color: #888; 
                    font-size: 11px;
                    float: right;
                }
                .description { 
                    font-size: 12px; 
                    margin-top: 5px;
                }
                .skills { 
                    font-size: 12px;
                }
                .skill-tag {
                    display: inline-block;
                    background: #e3f2fd;
                    color: #1976d2;
                    padding: 2px 8px;
                    margin: 2px;
                    border-radius: 12px;
                    font-size: 11px;
                }
                .summary {
                    font-size: 12px;
                    line-height: 1.5;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="name"><?= htmlspecialchars($personal['full_name'] ?? 'Your Name') ?></div>
                <div class="contact-info">
                    <?= htmlspecialchars($personal['email'] ?? 'email@example.com') ?>
                    <span>•</span>
                    <?= htmlspecialchars($personal['phone'] ?? '(123) 456-7890') ?>
                    <?php if (!empty($personal['linkedin'])): ?>
                        <span>•</span>
                        <?= htmlspecialchars($personal['linkedin']) ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($personal['summary'])): ?>
            <div class="section">
                <div class="section-title">Summary</div>
                <div class="summary"><?= nl2br(htmlspecialchars($personal['summary'])) ?></div>
            </div>
            <?php endif; ?>

            <div class="section">
                <div class="section-title">Experience</div>
                <?php if (!empty($experience)): ?>
                    <?php foreach ($experience as $exp): ?>
                        <div class="experience-item">
                            <div class="job-title"><?= htmlspecialchars($exp['job_title'] ?? '') ?></div>
                            <div class="company">
                                <?= htmlspecialchars($exp['company'] ?? '') ?>
                                <span class="duration"><?= htmlspecialchars($exp['duration'] ?? '') ?></span>
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

            <div class="section">
                <div class="section-title">Education</div>
                <?php if (!empty($education)): ?>
                    <?php foreach ($education as $edu): ?>
                        <div class="education-item">
                            <div class="job-title"><?= htmlspecialchars($edu['degree'] ?? '') ?></div>
                            <div class="institution">
                                <?= htmlspecialchars($edu['institution'] ?? '') ?>
                                <span class="duration"><?= htmlspecialchars($edu['year'] ?? '') ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="education-item">
                        <div class="description">Your education will appear here...</div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($skills)): ?>
            <div class="section">
                <div class="section-title">Skills</div>
                <div class="skills">
                    <?php foreach ($skills as $skill): ?>
                        <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </body>
        </html>
        <?php
    } else {
        // Web version with Tailwind CSS
        ?>
        <div class="template1 bg-white p-8 text-gray-800 font-sans">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($personal['full_name'] ?? 'Your Name') ?></h1>
                <div class="flex justify-center gap-4 text-sm text-gray-600">
                    <span><?= htmlspecialchars($personal['email'] ?? 'email@example.com') ?></span>
                    <span>•</span>
                    <span><?= htmlspecialchars($personal['phone'] ?? '(123) 456-7890') ?></span>
                    <?php if (!empty($personal['linkedin'])): ?>
                        <span>•</span>
                        <span><?= htmlspecialchars($personal['linkedin']) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Summary -->
            <?php if (!empty($personal['summary'])): ?>
            <div class="mb-6">
                <h2 class="text-xl font-bold text-blue-600 border-b-2 border-blue-600 pb-1 mb-3">Summary</h2>
                <p class="text-sm leading-relaxed"><?= nl2br(htmlspecialchars($personal['summary'])) ?></p>
            </div>
            <?php endif; ?>

            <!-- Experience -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-blue-600 border-b-2 border-blue-600 pb-1 mb-3">Experience</h2>
                <?php if (!empty($experience)): ?>
                    <?php foreach ($experience as $exp): ?>
                        <div class="mb-4">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg"><?= htmlspecialchars($exp['job_title'] ?? '') ?></h3>
                                <span class="text-sm text-gray-600"><?= htmlspecialchars($exp['duration'] ?? '') ?></span>
                            </div>
                            <p class="text-sm text-gray-700 mb-1"><?= htmlspecialchars($exp['company'] ?? '') ?></p>
                            <p class="text-sm text-gray-600"><?= nl2br(htmlspecialchars($exp['description'] ?? '')) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-sm text-gray-500 italic">Your experience will appear here...</p>
                <?php endif; ?>
            </div>

            <!-- Education -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-blue-600 border-b-2 border-blue-600 pb-1 mb-3">Education</h2>
                <?php if (!empty($education)): ?>
                    <?php foreach ($education as $edu): ?>
                        <div class="mb-3">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold"><?= htmlspecialchars($edu['degree'] ?? '') ?></h3>
                                <span class="text-sm text-gray-600"><?= htmlspecialchars($edu['year'] ?? '') ?></span>
                            </div>
                            <p class="text-sm text-gray-700"><?= htmlspecialchars($edu['institution'] ?? '') ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-sm text-gray-500 italic">Your education will appear here...</p>
                <?php endif; ?>
            </div>

            <!-- Skills -->
            <?php if (!empty($skills)): ?>
            <div class="mb-6">
                <h2 class="text-xl font-bold text-blue-600 border-b-2 border-blue-600 pb-1 mb-3">Skills</h2>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($skills as $skill): ?>
                        <span class="bg-gray-200 text-gray-800 text-xs font-medium px-3 py-1.5 rounded-full">
                            <?= htmlspecialchars($skill) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
?>