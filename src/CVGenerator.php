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
                    margin-bottom: 10px; 
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
                .contact-info {
                    margin-bottom: 10px;
                }
            </style>
        </head>
        <body>
            <div class="header"><?= htmlspecialchars($firstName) ?> <?= htmlspecialchars($lastName) ?></div>
            <div class="divider"></div>
            
            <div class="contact-info">
                <?= htmlspecialchars($address) ?>, <?= htmlspecialchars($telephone) ?>, <?= htmlspecialchars($email) ?><?php if ($linkedin): ?>, <?= htmlspecialchars($linkedin) ?><?php endif; ?>
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
                <div class="reference">Reference: <?= htmlspecialchars($exp['reference']) ?></div>
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
            <?php endforeach; ?>
            <?php endif; ?>
            
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
} 