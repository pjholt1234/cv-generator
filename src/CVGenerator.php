<?php

namespace CVGenerator;

use Dompdf\Dompdf;

class CVGenerator
{
    public function generate(array $data, string $outputPath): void
    {
        $html = $this->buildHtml($data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        file_put_contents($outputPath, $dompdf->output());
    }

    private function buildHtml(array $data): string
    {
        // Extract data with defaults
        $firstName = $data['first_name'] ?? '';
        $lastName = $data['last_name'] ?? '';
        $address = $data['address'] ?? '';
        $telephone = $data['telephone'] ?? '';
        $email = $data['email'] ?? '';
        $linkedin = $data['linkedin'] ?? '';
        $introduction = $data['introduction'] ?? '';
        $experience = $data['experience'] ?? [];
        $education = $data['education'] ?? [];
        $optional = $data['optional'] ?? [];

        ob_start();
        ?>
        <html>
        <head>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    font-size: 12px; 
                    color: #222; 
                    margin: 20px;
                    line-height: 1.4;
                }
                .header { 
                    font-size: 24px; 
                    font-weight: bold; 
                    margin-bottom: 10px;
                }
                .divider { 
                    border-bottom: 2px solid #222; 
                    margin: 10px 0; 
                }
                .section-title { 
                    font-size: 18px; 
                    font-weight: bold; 
                    margin-top: 20px; 
                    margin-bottom: 10px;
                }
                .company-row { 
                    display: flex; 
                    justify-content: space-between; 
                    font-weight: bold; 
                    margin-top: 15px;
                }
                .role { 
                    font-style: italic; 
                    margin-bottom: 5px; 
                    margin-top: 5px;
                }
                ul { 
                    margin-top: 5px; 
                    margin-bottom: 5px;
                    padding-left: 20px;
                }
                .reference { 
                    font-size: 11px; 
                    color: #666; 
                    margin: 8px 0; 
                    padding: 8px;
                    border: 1px solid #ddd;
                    background-color: #f9f9f9;
                }
                .reference-title {
                    font-weight: bold;
                    margin-bottom: 6px;
                }
                .reference-details {
                    margin-left: 10px;
                }
                .reference-line {
                    display: flex;
                    justify-content: space-between;
                }
                .reference-label {
                    font-weight: bold;
                    margin-right: 5px;
                }
                .reference-relationship {
                    margin-top: 5px;
                    font-style: italic;
                }
                .edu-row { 
                    display: flex; 
                    justify-content: space-between; 
                    font-weight: bold; 
                    margin-top: 15px;
                }
                .qualification {
                    font-style: italic; 
                    margin-bottom: 5px; 
                    margin-top: 5px;
                }
                .optional-title { 
                    font-size: 16px; 
                    font-weight: bold; 
                    margin-top: 15px;
                }
                .optional-subtitle { 
                    font-size: 13px; 
                    font-style: italic; 
                    margin-bottom: 5px;
                }
                .subsection-title {
                    font-size: 14px;
                    font-weight: bold;
                    margin-top: 10px;
                    margin-bottom: 5px;
                }
                .subsection-subtitle {
                    font-size: 12px;
                    font-style: italic;
                    margin-bottom: 5px;
                }
                .contact-info {
                    margin-bottom: 10px;
                    line-height: 1.6;
                }
                .contact-info .label {
                    font-weight: bold;
                    margin-right: 5px;
                }
                .contact-info span {
                    margin-right: 15px;
                }
            </style>
        </head>
        <body>
            <div class="header"><?= htmlspecialchars($firstName) ?> <?= htmlspecialchars($lastName) ?><?php if (isset($data['title'])): ?> - <?= htmlspecialchars($data['title']) ?><?php endif; ?></div>
            <div class="divider"></div>
            
            <div class="contact-info">
                <span><span class="label">Address:</span><?= htmlspecialchars($address) ?></span>
                <span><span class="label">Phone Number:</span><?= htmlspecialchars($telephone) ?></span>
                <span><span class="label">Email:</span><?= htmlspecialchars($email) ?></span>
                <?php if ($linkedin): ?><span><span class="label">LinkedIn:</span><?= htmlspecialchars($linkedin) ?></span><?php endif; ?>
            </div>
            <div class="divider"></div>
            
            <?php if ($introduction): ?>
            <div><?= nl2br(htmlspecialchars($introduction)) ?></div>
            <div class="divider"></div>
            <?php endif; ?>
            
            <?php if (!empty($experience)): ?>
            <div class="section-title">Professional experience</div>
            <?php foreach ($experience as $exp): ?>
                <div class="company-row">
                    <span><?= htmlspecialchars($exp['company'] ?? '') ?></span>
                    <span><?= htmlspecialchars($exp['date_start'] ?? '') ?> - <?= htmlspecialchars($exp['date_end'] ?? '') ?></span>
                </div>
                <div class="role"><?= htmlspecialchars($exp['role'] ?? '') ?></div>
                <?php if (!empty($exp['bullets'])): ?>
                <ul>
                    <?php foreach ($exp['bullets'] as $bullet): ?>
                    <li><?= htmlspecialchars($bullet) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <?php if (!empty($exp['reference'])): ?>
                <div class="reference">
                    <div class="reference-title">Reference</div>
                    <div class="reference-details">
                        <div class="reference-line">
                            <div>
                                <span class="reference-label">Name:</span>
                                <?= htmlspecialchars($exp['reference']['name']) ?> - 
                                <span class="reference-label">Position:</span>
                                <?= htmlspecialchars($exp['reference']['job_title']) ?> at <?= htmlspecialchars($exp['reference']['company']) ?>
                            </div>
                        </div>
                        <div class="reference-line">
                            <div>
                                <span class="reference-label">Contact:</span>
                                <?= htmlspecialchars($exp['reference']['phone']) ?> | 
                                <?= htmlspecialchars($exp['reference']['email']) ?>
                            </div>
                        </div>
                        <div class="reference-relationship">
                            <?= htmlspecialchars($exp['reference']['relationship']) ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="divider"></div>
            <?php endif; ?>
            
            <?php if (!empty($education)): ?>
            <div class="section-title">Education</div>
            <?php foreach ($education as $edu): ?>
                <div class="edu-row">
                    <span><?= htmlspecialchars($edu['institution'] ?? '') ?></span>
                    <span><?= htmlspecialchars($edu['date_start'] ?? '') ?> - <?= htmlspecialchars($edu['date_end'] ?? '') ?></span>
                </div>
                <div class="qualification"><?= htmlspecialchars($edu['qualification'] ?? '') ?></div>
                <?php if (!empty($edu['bullets'])): ?>
                <ul>
                    <?php foreach ($edu['bullets'] as $bullet): ?>
                    <li><?= htmlspecialchars($bullet) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="divider"></div>
            <?php endif; ?>
            
            <?php if (!empty($optional)): ?>
            <?php foreach ($optional as $section): ?>
                <div class="optional-title"><?= htmlspecialchars($section['title'] ?? '') ?></div>
                <?php if (!empty($section['subtitle'])): ?>
                <div class="optional-subtitle"><?= htmlspecialchars($section['subtitle']) ?></div>
                <?php endif; ?>
                <?php if (!empty($section['bullets'])): ?>
                <ul>
                    <?php foreach ($section['bullets'] as $bullet): ?>
                    <li><?= htmlspecialchars($bullet) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <?php if (!empty($section['subsections'])): ?>
                    <?php foreach ($section['subsections'] as $subsection): ?>
                        <div class="subsection-title"><?= htmlspecialchars($subsection['title']) ?></div>
                        <?php if (!empty($subsection['subtitle'])): ?>
                        <div class="subsection-subtitle"><?= htmlspecialchars($subsection['subtitle']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($subsection['bullets'])): ?>
                        <ul>
                            <?php foreach ($subsection['bullets'] as $bullet): ?>
                            <li><?= htmlspecialchars($bullet) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="divider"></div>
            <?php endforeach; ?>
            <?php endif; ?>
            
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
} 