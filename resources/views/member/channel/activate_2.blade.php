@extends("layouts.app")

@section('content')

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
            'home' => '/',
            'channel' => '/member/channel',
            'activate' => '/member/channel/active/2',
        ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- //Add classes .step-2 and .step-3 to display progress --}}
                <ul class="activation-tracker">
                    <li><span>1</span></li>
                    <li><span>2</span></li>
                    <li><span>3</span></li>
                </ul>
                <h2 class="mt-2 mb-1">Terms of service</h2>
                <div class="channel-terms">
                    <article>
                        <h1 class="mt-2 mb-2 text-center">Terms of service</h1>
                        <p class="mb-1">This website (the “Site”) is owned and operated by TheDojo.com, LLC (“TheDojo.com”).   By using materials, reports, data, and content on this Site (“Content”), you signify your agreement to these terms of use (“Terms of Use”).  These Term of Use apply to all users of the Site, including without limitation users who are browsers, vendors, customers, merchants, and/or contributors of content.  If you do not agree to these Terms of Use, you may not use the Site or any Content, products, services, or reports included on or otherwise made available to you through the Site.</p>
                        <p class="mb-1">Note that special terms may apply to content providers and some products or services offered on the Site, subscription-based services, rules for particular contests or sweepstakes, or other features or activities. These special terms shall be posted in connection with the applicable Site area, product, or service. Any such special terms are in addition to these Terms of Use, and in the event of a conflict, prevail over these Terms of Use. </p>
                        <p class="mb-1">By using Content on the Site, you acknowledge that these Terms of Use are supported by reasonable and valuable consideration, the receipt and adequacy of which is hereby acknowledged. Without limiting the generality of the foregoing, you acknowledge that such consideration includes your use of the Site and receipt of Content available at or through the Site. TheDojo.com may change these Terms of Use at any time by posting modified, updated or new applicable terms and conditions. Your continued use of the Site after any such posting indicates that you accept any such changes to these Terms of Use. It is therefore important that you review these Terms of Use regularly to ensure you are updated as to any modifications.</p>
                    </article>
                    <article>
                        <h4 class="mt-3 mb-1">License and Site Access</h4>
                        <p class="mb-1">TheDojo.com grants you a limited, revocable license to access and make personal use of the Site or the Content.  You may not copy or modify the Content, or any portion of it, except with express written consent of TheDojo.com. This license does not include the right to resell Content or make any commercial use of the Site or the Content; any collection and use of any product listings, descriptions, or prices; any modification, publication, display or derivative use of the Site or the Content; any downloading or copying of account information for the benefit of another merchant; or any use of screen scraping, database scraping, data mining, robots, spiders or similar data gathering and extraction tools.</p>
                        <p class="mb-1">All Content, including text, graphic images, videos, code, and software, are copyrighted materials of TheDojo.com or the original creator, with all rights reserved. Trademarks, service marks, trade names and logos (“Trademarks”) used or displayed on the Site or the Content are registered or unregistered Trademarks of TheDojo.com. TheDojo.com owns the Site and the Content and retains all intellectual property rights in and to the Site and Content. Neither the Site nor any Content may be reproduced, duplicated, copied, sold, resold, visited, or otherwise exploited for any commercial purpose without express written consent of TheDojo.com. You may not frame or utilize framing techniques to enclose any Trademark or other proprietary information (including images, text, page layout, or form) contained on the Site. You may not utilize any of TheDojo.com’s Trademarks as part of a link to the Site or any other website or in any meta tags or any other “hidden text”, without the express written consent of TheDojo.com. Any unauthorized use terminates the permission or license granted by TheDojo.com.
                        </p>
                        <p class="mb-1">The Site may be unavailable from time to time for routine or other maintenance, security, or other purposes in TheDojo.com’s sole discretion. As with all information you send over the Internet, information that you send to or receive from the Site is subject to interception, misappropriation, and misuse by third parties.</p>
                    </article>
                    <article>
                        <h4 class="mt-3 mb-1">Public Forum, Submissions and Submission License</h4>
                        <p class="mb-1">The functionality of the Site may include chat areas, message boards, conversation pages, e-mail functions and similar opportunities (each a “Public Forum”) for you to submit, provide or to otherwise make available, text, comments, messages, e-mails, photographs, videos and other content (each a “Submission” and collectively “Submissions”) for display on a Site. You acknowledge that Public Forums and features offered therein are for public and not private communications, and you have no expectation of privacy with regard to any Submission to a Public Forum. TheDojo.com cannot guarantee the security of any information you disclose through any Public Forum and you make such disclosures at your own risk. TheDojo.com does not endorse any opinions, advice, recommendations, or other materials posted in any Public Forum, and you acknowledge that your use of any Submission posted in a Public Forum is solely at your own risk.</p>
                        <p class="mb-1">You agree that you will not make any submission that (i) is defamatory, abusive, threatening, bigoted, vulgar, violent, obscene, sexually explicit, libelous, defamatory or generally offensive (including “flaming”), (ii) is illegal or encourages illegal activity, (iii) infringes on any proprietary right or right of privacy of any third party or violates any confidentiality obligation, (iv) contains any virus or harmful component or otherwise interferes with the operation, or impairs the functionality, of the Site (each a “Prohibited Submission”).</p>
                        <p class="mb-1">You hereby grant TheDojo.com and its distributors, agents, representatives and other authorized users, a perpetual, non-exclusive, irrevocable, royalty-free, sub-licensable and transferable (in whole or part) worldwide license under all copyrights, trademarks, patents, trade secrets, privacy and publicity rights and other intellectual property rights you own or control to use, reproduce, transmit, display, exhibit, distribute, index, comment on, modify, create derivative works based upon and otherwise exploit all Submissions, in whole or in part, in all media formats and channels now known or hereafter devised for any and all purposes including advertising, promotional, marketing, publicity, trade or commercial purposes, all without further notice to you, with or without attribution, and without the requirement of any permission from or payment to you or to any other person or entity. To the extent any “moral rights,” “ancillary rights,” or similar rights in or to the Submissions exist and are not exclusively owned by TheDojo.com, you agree not to enforce any such rights as to TheDojo.com or its distributors, agents, representatives and other authorized users, and you shall procure the same agreement not to enforce from any others who may possess such rights.</p>
                        <p class="mb-1">You are and shall remain solely responsible for any Submission that you provide. Without limiting any of its rights in law and equity, TheDojo.com reserves the right, in its sole discretion, to refuse to post or communicate any Submission, and to remove any Submission, for any reason, including any Submission that it believes to be a Prohibited Submission or deems to be in violation of these Terms of Use.</p>
                    </article>
                    <article>
                        <h4 class="mt-3 mb-1">DISCLAIMER OF WARRANTIES AND LIMITATION OF LIABILITY</h4>
                        <p class="mb-1">THE SITE AND ALL CONTENT, INFORMATION, MATERIALS, PRODUCTS, SERVICES, REPORTS AND SUBMISSIONS INCLUDED ON OR OTHERWISE MADE AVAILABLE TO YOU THROUGH THE SITE ARE PROVIDED ON AN “AS IS” AND “AS AVAILABLE” BASIS. YOU EXPRESSLY AGREE THAT YOUR USE OF THE SITE IS AT YOUR SOLE RISK.</p>
                        <p class="mb-1">TheDojo.com HEREBY DISCLAIMS ALL REPRESENTATIONS AND WARRANTIES OF ANY KIND (WHETHER EXPRESS OR IMPLIED), INCLUDING, WITHOUT LIMITATION, ANY WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, SATISFACTION OF YOUR REQUIREMENTS, ARISING OUT OF A COURSE OF PERFORMANCE, DEALING OR TRADE USAGE, DATA ACCURACY, SYSTEM ACCESS, INTEGRATION OR INFORMATIONAL CONTENT, OR OF FREEDOM FROM NON-INFRINGEMENT, ERROR, INTERRUPTION, VIRUS OR OTHER DISABLING ROUTINE.</p>
                        <p class="mb-1">IF YOU HAVE ANY BASIS FOR RECOVERING DAMAGES (INCLUDING NEGLIGENCE OR BREACH OF THESE TERMS OF USE), YOU AGREE THAT YOUR EXCLUSIVE REMEDY IS TO RECOVER FROM  TheDojo.com OR ANY OF ITS DIRECTORS, MANAGERS, OFFICERS, EMPLOYEES, AGENTS, CONTRACTORS OR OTHER REPRESENTATIVES DIRECT DAMAGES UP TO FIFTY DOLLARS ($50.00) DOLLARS.  TheDojo.com, ITS DIRECTORS, MANAGERS, OFFICERS, EMPLOYEES, AGENTS, CONTRACTORS OR OTHER REPRESENTATIVES SHALL NOT BE LIABLE FOR ANY INDIRECT, SPECIAL, INCIDENTAL, PUNITIVE, EXEMPLARY OR CONSEQUENTIAL DAMAGES OF ANY KIND, INCLUDING, WITHOUT LIMITATION, LOST PROFITS, LOST REVENUES OR LOSS OF BUSINESS, EVEN IF TheDojo.com HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES AND NOTWITHSTANDING THE FAILURE OF THE ESSENTIAL PURPOSE OF ANY LIMITED REMEDY, OR FOR ANY CLAIM AGAINST YOU BY ANY OTHER PARTY. THE LIMITATIONS, EXCLUSIONS AND DISCLAIMERS IN THIS SECTION AND ELSEWHERE IN THESE TERMS OF USE APPLY TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW.  YOU AGREE THAT ANY CAUSE OF ACTION ARISING OUT OF OR RELATED TO THE SERVICES MUST COMMENCE WITHIN ONE (1) YEAR AFTER THE CAUSE OF ACTION ACCRUES. OTHERWISE, SUCH CAUSE OF ACTION IS PERMANENTLY BARRED.</p>
                    </article>
                    <article>
                        <h4 class="mt-3 mb-1">User Account</h4>
                        <p class="mb-1">You agree to keep your User Account confidential, to prevent the use of your User Account by others, and to notify TheDojo.com promptly of any identified unauthorized access or use of your User Account. You may not sell, resell, license, rent, lease, reproduce, duplicate, copy or otherwise exploit your User Account distribute or provide access to any products or services available on the Site in a service bureau, out-sourcing, data processing or similar arrangement.</p>
                    </article>
                    <article>
                        <h4 class="mt-3 mb-1">Payment of Fees</h4>
                        <p class="mb-1">You agree to pay all applicable fees and costs for any services purchased by you or under your User Account, on or before the due date indicated on any invoice provided to you. You also responsible for the payment of any taxes arising from any purchased services. All fees and costs are final and will not be refunded in whole or in part. You agree that if any legal action is required to enforce TheDojo.com’s right to payment of any fees, costs or any other amounts due for any purchased products, you will be responsible to pay all costs incurred by TheDojo.com, including reasonable attorney’s fees, arising from any such action or any appeal thereof.</p>
                    </article>
                    <article>
                        <h4 class="mt-3 mb-1">Indemnification</h4>
                        <p class="mb-1">You agree to indemnify, defend and hold harmless TheDojo.com and any of its directors, managers, officers, employees, agents, contractors and other representatives from all claims, demands, losses, expenses and costs whatsoever (including reasonable attorney’s fees) arising, directly or indirectly, out of your access, use, disclosure, publication, display or distribution of (a) the Site, (b) any of the Content or information (including any information contained in any Submission) you obtain from the Site, (c) any products you purchase or reports made available to you from the Site, (d) any Links or any Advertising, as well as any Submission you provide to the Site and any breach by you of these Terms of Use or related TheDojo.com procedures.</p>
                    </article>
                    <article>
                        <h4 class="mt-3 mb-1">Promotional Communications; Privacy Policy</h4>
                        <p class="mb-1">You agree to receive from TheDojo.com e-mail messages pertaining to the products and services offered on or through the Site or advertising that TheDojo.com determines may be of interest to you. Please see TheDojo.com’s Privacy Policy at <a href="/privacy-policy" style="font-weight: bold">The Privacy Policy Section</a> for an explanation of how TheDojo.com may collect information from you, how TheDojo.com uses such information and your ability to opt-out of receiving promotional communications. The terms and conditions of the Privacy Policy are hereby incorporated by reference into these Terms of Use. TheDojo.com may change the Privacy Policy at any time in its sole discretion and any such changes shall be deemed to be incorporated into these Terms of Use.</p>
                    </article>
                    <article>
                        <h4 class="mt-3 mb-1">Links</h4>
                        <p class="mb-1">From time to time, the Site may contain hyperlinks (“Links”) to third-party websites. Such Links are for your reference only, and TheDojo.com neither controls such linked websites nor is TheDojo.com liable or responsible in any way for their content. Display of such Links on the Site does not imply or express any endorsement by TheDojo.com of any individuals or entities referred to in the content on such linked websites, or of such Links, or any association with their operators and TheDojo.com recommends that you review the terms of use and privacy policies of any such linked websites.</p>
                    </article>
                    <article>
                        <h4 class="mt-3 mb-1">Termination</h4>
                        <p class="mb-1">Notwithstanding any of these terms and conditions, TheDojo.com reserves the right, without notice and in its sole discretion, to suspend or terminate your license and ability to access the Site (including, if applicable, your User Account), and to block or prevent you from future access to the Site, including any products or reports available through the Site.</p>
                    </article>
                    <article>
                        <h4 class="mt-3 mb-1">Miscellaneous</h4>
                        <p class="mb-1">These Terms of Use are governed by California law, without regard to its conflicts of laws principles. If a court of competent jurisdiction finds that any provision in any section of these Terms of Use is illegal, unenforceable or invalid in any respect, then such provision will be ineffective to the extent of such finding without affecting the enforceability or validity of the section in which such provision is found, or any other section of these Terms of Use. Unless otherwise stated herein, these Terms of Use constitute the entire agreement between the parties with respect to the subject matter hereof and supersede all prior statements or agreements, both written and oral. TheDojo.com may change the features and functionality of or access to all or any part of the Site or the related services from time to time, with or without notice.</p>
                    </article>
                </div>
                <a href="{{ route('channel.active3') }}" class="bt bt-block bt-1 text-center mt-3 mb-3">I agree to the terms and conditions</a>
            </div>
        </div>
    </div>
</main>
@stop

