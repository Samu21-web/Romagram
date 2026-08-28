<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::updateOrCreate(['slug' => 'privacy-policy'], [
            'title'           => 'Privacy Policy',
            'last_updated_at' => now(),
            'content'         => '<h2>Introduction</h2>
<p>Welcome to Rompace. We are committed to protecting your personal information and your right to privacy.</p>

<h2>Information We Collect</h2>
<p>We collect information you provide directly to us, such as when you create an account, update your profile, or contact us for support.</p>
<ul>
<li>Name, email address, and phone number</li>
<li>Profile information including age, gender, and location</li>
<li>Photos you upload to your profile</li>
<li>Messages you send through our platform</li>
</ul>

<h2>How We Use Your Information</h2>
<p>We use the information we collect to provide, maintain, and improve our services, process transactions, and communicate with you.</p>

<h2>Information Sharing</h2>
<p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>

<h2>Data Security</h2>
<p>We implement appropriate technical and organisational measures to protect your personal information against unauthorised access, alteration, disclosure, or destruction.</p>

<h2>Contact Us</h2>
<p>If you have any questions about this Privacy Policy, please contact us at privacy@rompace.com.</p>',
        ]);

        Page::updateOrCreate(['slug' => 'terms-of-service'], [
            'title'           => 'Terms of Service',
            'last_updated_at' => now(),
            'content'         => '<h2>Acceptance of Terms</h2>
<p>By accessing and using Rompace, you accept and agree to be bound by these Terms of Service.</p>

<h2>Eligibility</h2>
<p>You must be at least 18 years of age to use Rompace. By using our service, you confirm that you are 18 or older.</p>

<h2>Account Responsibilities</h2>
<ul>
<li>You are responsible for maintaining the confidentiality of your account credentials</li>
<li>You agree to provide accurate and truthful information on your profile</li>
<li>You are responsible for all activities that occur under your account</li>
</ul>

<h2>Prohibited Conduct</h2>
<p>You agree not to engage in any of the following:</p>
<ul>
<li>Harassing, abusing, or harming other users</li>
<li>Posting false or misleading information</li>
<li>Using the service for commercial purposes without permission</li>
<li>Attempting to gain unauthorised access to other accounts</li>
</ul>

<h2>Premium Subscriptions</h2>
<p>Premium subscriptions are billed in advance. Refunds are handled on a case-by-case basis. You may cancel your subscription at any time.</p>

<h2>Termination</h2>
<p>We reserve the right to terminate or suspend your account at our sole discretion, without notice, for conduct that we believe violates these Terms.</p>

<h2>Contact Us</h2>
<p>For questions about these Terms, contact us at legal@rompace.com.</p>',
        ]);
    }
}