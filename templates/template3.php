<?php
function renderTemplate3($data, $forPdf = false) {
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
                    background: #f8f9fa;
                }
                .resume-container {
                    background: white;
                    border-radius: 8px;
                    padding: 30px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                }
                .header { 
                    text-align: center; 
                    margin-bottom: 30px;
                    padding-bottom: 20px;
                    border-bottom: 3px double #27ae60;
                }
                .name { 
                    font-size: 26px; 
                    font-weight: bold; 
                    color: #27ae60;
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
                    margin-bottom: 25px;
                }
                .section-title { 
                    font-size: 16px; 
                    font-weight: bold; 
                    color: #27ae60;
                    background: #e8f5e8;
                    padding: 8px 15px;
                    border-radius: 5px;
                    margin-bottom: 15px;
                }
                .experience-item, .education-item { 
                    margin-bottom: 15px;
                    padding-left: 15px;
                    border-left: 2px solid #27ae60;
                }
                .job-title { 
                    font-weight: bold; 
                    font-size: 14px;
                    color: #2c3e50;
                }
                .company, .institution { 
                    color: #666; 
                    font-size: 12px;
                    margin-bottom: 5px;
                }
                .duration { 
                    color: #888; 
                    font-size: 11px;
                    font-style: italic;
                }
                .description { 
                    font-size: 12px; 
                    margin-top: 5px;
                    color: #555;
                }
                .skills { 
                    font-size: 12px;
                }
                .skill-tag {
                    display: inline-block;
                    background: #27ae60;
                    color: white;
                    padding: 3px 10px;
                    margin: 2px;
                    border-radius: 15px;
                    font-size: 11px;
                }
                .summary {
                    font-size: 12px;
                    line-height: 1.5;
                    color: #555;
                    text-align: center;
                    font-style: italic;
                }
            </style>
        </head>
        <body>
            <div class="resume-container">
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
            </div>
        </body>
        </html>
        <?php
    } else {
        // Web version with Tailwind CSS
        ?>
        <div class="template3 bg-white p-8 text-gray-800 font-sans rounded-lg shadow-lg border">
            <!-- Header -->
            <div class="text-center mb-8 border-b-2 border-green-500 pb-6">
                <h1 class="text-4xl font-bold text-green-600 mb-2"><?= htmlspecialchars($personal['full_name'] ?? 'Your Name') ?></h1>
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
            <div class="mb-6 text-center">
                <p class="text-sm leading-relaxed text-gray-600 italic"><?= nl2br(htmlspecialchars($personal['summary'])) ?></p>
            </div>
            <?php endif; ?>

            <!-- Experience -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-green-600 bg-green-50 px-4 py-2 rounded-lg mb-4">Experience</h2>
                <?php if (!empty($experience)): ?>
                    <?php foreach ($experience as $exp): ?>
                        <div class="mb-4 pl-4 border-l-4 border-green-500">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg text-gray-900"><?= htmlspecialchars($exp['job_title'] ?? '') ?></h3>
                                <span class="text-sm text-gray-500 italic"><?= htmlspecialchars($exp['duration'] ?? '') ?></span>
                            </div>
                            <p class="text-sm text-gray-700 mb-1"><?= htmlspecialchars($exp['company'] ?? '') ?></p>
                            <p class="text-sm text-gray-600"><?= nl2br(htmlspecialchars($exp['description'] ?? '')) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-sm text-gray-500 italic pl-4">Your experience will appear here...</p>
                <?php endif; ?>
            </div>

            <!-- Education -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-green-600 bg-green-50 px-4 py-2 rounded-lg mb-4">Education</h2>
                <?php if (!empty($education)): ?>
                    <?php foreach ($education as $edu): ?>
                        <div class="mb-3 pl-4 border-l-4 border-green-500">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-gray-900"><?= htmlspecialchars($edu['degree'] ?? '') ?></h3>
                                <span class="text-sm text-gray-500 italic"><?= htmlspecialchars($edu['year'] ?? '') ?></span>
                            </div>
                            <p class="text-sm text-gray-700"><?= htmlspecialchars($edu['institution'] ?? '') ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-sm text-gray-500 italic pl-4">Your education will appear here...</p>
                <?php endif; ?>
            </div>

            <!-- Skills -->
            <?php if (!empty($skills)): ?>
            <div class="mb-6">
                <h2 class="text-xl font-bold text-green-600 bg-green-50 px-4 py-2 rounded-lg mb-4">Skills</h2>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($skills as $skill): ?>
                        <span class="bg-green-500 text-white text-xs font-medium px-3 py-1.5 rounded-full">
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