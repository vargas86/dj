@extends('layouts.app')

@section('content')
<main>

    @component('components.bread-crumbs', ['crumbs' =>
    [
    'home' => '/',
    'privacy policy' => route('privacy.policy')
    ]
    ])
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-2 mb-2 text-center">Privacy policy</h1>

                <p>We want you to understand how and why TheDojo.com (“TheDojo,” “we” or “us”) collects, uses, and
                    shares information about you when you use our sites, mobile applications, tools, and other online
                    products and services (collectively, the "Services") or when you otherwise interact with us or
                    receive a communication from us. This Privacy Policy applies to all of our Services.</p>
                <br>
                <h4>What We Collect (and How it is Used and Shared)</h4>
                <p><u>Information You Provide to Us</u></p>
                <p>We collect information you provide to us directly when you use the Services. This includes:</p>
                <br>
                <table style="width:100%;">
                    <tr>
                        <td style="width:200px;padding:10px">Account information</td>
                        <td style="padding:10px">If you create a TheDojo account, we may require you to provide a
                            username and password. Your username is public, and it does not have to be related to your
                            real name. You may also provide other account information, like an email address, bio, or
                            profile picture. We also may store your user account preferences and settings.</td>
                    </tr>
                    <tr>
                        <td style="padding:10px">Content you submit</td>
                        <td style="padding:10px">We collect the content you submit to the Services. This includes your
                            posts and comments including saved drafts, videos you broadcast, your messages with other
                            users (e.g., private messages), and your reports and other communications with moderators
                            and with us. Your content may include text, links, images, gifs, and videos.</td>
                    </tr>
                    <tr>
                        <td style="width:200px;padding:10px">Actions you take</td>
                        <td style="padding:10px">We collect information about the actions you take when using the
                            Services. This includes your interactions with content and your interactions with other
                            users.</td>
                    </tr>
                    <tr>
                        <td style="width:200px;padding:10px">Transactional information</td>
                        <td style="padding:10px">If you purchase products or services from us, we will collect certain
                            information from you, including your name, address, email address, and information about the
                            product or service you are purchasing. TheDojo uses industry-standard payment processor
                            services to handle payment information.</td>
                    </tr>
                    <tr>
                        <td style="width:200px;padding:10px">Other information</td>
                        <td style="padding:10px">You may choose to provide other information directly to us. For
                            example, we may collect information when you fill out a form, participate in
                            TheDojo-sponsored activities or promotions, request customer support, or otherwise
                            communicate with us.</td>
                    </tr>
                </table>

                <p><u>Information We Collect Automatically</u></p>
                <p>When you access or use our Services, we may also automatically collect information about you. This
                    includes:</p>
                <br>
                <table style="width:100%;">
                    <tr>
                        <td style="width:200px;padding:10px">Log and usage data</td>
                        <td style="padding:10px">We may log information when you access and use the Services. This may
                            include your IP address, user-agent string, browser type, operating system, referral URLs,
                            device information (e.g., device IDs), device settings, pages visited, links clicked, the
                            requested URL, and search terms. Except for the IP address used to create your account,
                            TheDojo will delete any IP addresses collected after 100 days.</td>
                    </tr>
                    <tr>
                        <td style="width:200px;padding:10px">Information collected from cookies and similar technologies
                        </td>
                        <td style="padding:10px">We may receive information from cookies, which are pieces of data your
                            browser stores and sends back to us when making requests, and similar technologies. We use
                            this information to improve your experience, understand user activity, personalize content
                            and advertisements, and improve the quality of our Services. If TheDojo plans to make use of
                            information received from cookies, we will provide notice to you and you may elect to
                            disable cookies.</td>
                    </tr>
                    <tr>
                        <td style="width:200px;padding:10px">Location information</td>
                        <td style="padding:10px">We may receive and process information about your location. For
                            example, with your consent, we may collect information about the specific location of your
                            mobile device (for example, by using GPS or Bluetooth). We may also receive location
                            information from you when you choose to share such information on our Services, including by
                            associating your content with a location, or we may derive your approximate location from
                            other information about you, including your IP address.</td>
                    </tr>
                </table>


                <p><u>Information Collected from Other Sources</u></p>
                <p>We may receive information about you from other sources, including from other users and third
                    parties, and combine that information with the other information we have about you. For example, we
                    may receive demographic or interest information about you from third parties, including advertisers
                    (such as the fact that an advertiser is interested in showing you an ad), and combine it with our
                    own data using a common account identifier such as a hash of an email address or a mobile-device ID.
                    You can control how we use this information to personalize the Services for you as described below.
                </p>
                <br>
                <table style="width:100%;">
                    <tr>
                        <td style="width:200px;padding:10px">Information collected from integrations</td>
                        <td style="padding:10px">We also may receive information about you, including log and usage data
                            and cookie information, from third-party sites that integrate our Services, including our
                            embeds and advertising technology. For example, when you visit a site that is access via a
                            link from TheDojo, we may receive information about the web page you visited. Similarly, if
                            an advertiser incorporates TheDojo’s ad technology, TheDojo may receive limited information
                            about your activity on the advertiser’s site or app, such as whether you bought something
                            from the advertiser. You can control how we use this information to personalize the Services
                            for you as described below.</td>
                    </tr>
                </table>

                <p><u>Information Collected by Third Parties</u></p>
                <br>
                <tr>
                    <td style="width:200px;padding:10px">Embedded content</td>
                    <td style="padding:10px">TheDojo displays some linked content in-line on the TheDojo services. In
                        general, TheDojo does not control how third-party services collect data when they serve you
                        their content directly via these links. As a result, linked content is not covered by this
                        privacy policy but by the policies of the service from which the content is linked.</td>
                </tr>
                <tr>
                    <td style="width:200px;padding:10px">Programmatic ads</td>
                    <td style="padding:10px">We partner with third-party programmatic ad exchanges to show
                        advertisements relevant to your interests. In providing those ads, those third parties collect
                        information, including log and usage data and information from cookies as described above. These
                        third parties do not receive any information from your TheDojo account.</td>
                </tr>
                </table>
                <br><br>

                <p>We use information about you to:</p><br>
                <ul style="list-style-type: circle;margin-left:30px">
                    <li>Research and develop new services;</li>
                    <li>Help protect the safety of TheDojo and our users, which includes blocking suspected spammers,
                        addressing abuse, and enforcing the TheDojo User Agreement and our other policies;</li>
                    <li>Send you technical notices, updates, security alerts, invoices, and other support and
                        administrative messages;</li>
                    <li>Provide customer service;</li>
                    <li>Communicate with you about products, services, offers, promotions, and events, and provide other
                        news and information we think will be of interest to you (for information about how to opt out
                        of these communications, see below);</li>
                    <li>Monitor and analyze trends, usage, and activities in connection with our Services;</li>
                    <li>Measure the effectiveness of ads shown on our Services; and</li>
                    <li>Personalize the Services, and provide and optimize advertisements, content, and features that
                        match user profiles or interests.</li>
                </ul>
                <br><br>

                <p>Much of the information on the Services is public and accessible to everyone, even without an
                    account. By using the Services, you are directing us to share this information publicly and freely.
                </p><br>
                <p>When you submit content (including a post, comment, or chat message) to a public part of the
                    Services, any visitors to and users of our Services will be able to see that content, the username
                    associated with the content, and the date and time you originally submitted the content. TheDojo
                    allows other sites to embed public TheDojo content via our embed tools. TheDojo also allows third
                    parties to access public TheDojo content via the TheDojo API and other similar technologies.
                    Although some parts of the Services may be private or quarantined, they may become public (e.g., at
                    the moderator’s option in the case of private communities) and you should take that into
                    consideration before posting to the Services.</p><br>
                <p>Your TheDojo account has a profile page that is public. Your profile may contain information about
                    your activities on the Services, such as your username, prior posts and comments.</p><br>
                <p>TheDojo only shares nonpublic information about you in the following ways. </p><br>
                <p>With your consent. We may share information about you with your consent or at your direction.</p><br>


                <ul style="list-style-type: circle;margin-left:30px">
                    <li>With linked services. If you link your TheDojo account with a third-party service, TheDojo may
                        share the information you authorize with that third-party service. </li>
                    <li>With our service providers. We may share information with vendors, consultants, and other
                        service providers who need access to such information to carry out work for us. Their use of
                        personal data will be subject to appropriate confidentiality and security measures. A few
                        examples: (i) payment processors who process transactions on our behalf, (ii) cloud providers
                        who host our data and our services, (iii) third-party ads measurement providers who help us and
                        advertisers measure the performance of ads shown on our Services.</li>
                    <li>To comply with the law. We may share information in response to a request for information if we
                        believe disclosure is in accordance with, or required by, any applicable law, regulation, legal
                        process, or governmental request, including, but not limited to, meeting national security or
                        law enforcement requirements. To the extent the law allows it, we will attempt to provide you
                        with prior notice before disclosing your information in response to such a request. </li>
                    <li>In an emergency. We may share information if we believe it's necessary to prevent imminent and
                        serious bodily harm to a person.</li>
                    <li>To enforce our policies and rights. We may share information if we believe your actions are
                        inconsistent with our Terms of Use or other TheDojo policies, or to protect the rights,
                        property, and safety of ourselves and others.</li>
                    <li>Aggregated or de-identified information. We may share information about you that has been
                        aggregated or anonymized such that it cannot reasonably be used to identify you. For example, we
                        may show the total number of times a post has been upvoted without identifying who the visitors
                        were, or we may tell an advertiser how many people saw their ad</li>
                </ul>
                <br><br>

                <h4>How We Protect Your Information</h4>
                <p>We store the information we collect for as long as it is necessary for the purpose(s) for which we
                    originally collected it. We may retain certain information for legitimate business purposes or as
                    required by law.</p>
                <br>

                <h4>Your Choices</h4>
                <p>You have choices about how to protect and limit the collection, use, and sharing of information about
                    you when you use the Services. </p>

                <table style="width:100%;">
                    <tr>
                        <td style="width:200px;padding:10px">Accessing and Changing Your Information</td>
                        <td style="padding:10px">You can access and change certain information made available through
                            the Services on your account settings page.</td>
                    </tr>
                    <tr>
                        <td style="width:200px;padding:10px">Deleting Your Account</td>
                        <td style="padding:10px">You may delete your account information at any time from the user
                            preferences page. You can also submit a request to delete the personal information TheDojo
                            maintains about you. When you delete your account, your profile is no longer visible to
                            other users and disassociated from content you posted under that account. Please note,
                            however, that the posts, comments, and messages you submitted prior to deleting your account
                            will still be visible to others unless you first delete the specific content. We may also
                            retain certain information about you as required by law or for legitimate business purposes
                            after you delete your account.</td>
                    </tr>
                    <tr>
                        <td style="width:200px;padding:10px">Controlling the Use of Cookies</td>
                        <td style="padding:10px">Most web browsers are set to accept cookies by default. If you prefer,
                            you can usually choose to set your browser to remove or reject first- and third-party
                            cookies. Please note that if you choose to remove or reject cookies, this could affect the
                            availability and functionality of our Services.</td>
                    </tr>
                    <tr>
                        <td style="width:200px;padding:10px">Controlling Promotional Communications</td>
                        <td style="padding:10px">You may opt out of receiving some or all categories of promotional
                            communications from us by following the instructions in those communications or by updating
                            your email options in your account preferences at [Insert Link]. If you opt out of
                            promotional communications, we may still send you non-promotional communications, such as
                            information about your account or your use of the Services.</td>
                    </tr>
                </table>

                <p>Requests for a copy of the information TheDojo has about your account—including EU General Data
                    Protection Regulation (GDPR) data subject access requests and California Consumer Privacy Act (CCPA)
                    consumer information requests—can be submitted via email to admin@TheDojo.com.</p><br>

                <p>Before we process a request from you about your personal information, we need to verify the request
                    via your access to your TheDojo account or to a verified email address associated with your TheDojo
                    account. TheDojo does not discriminate against users for exercising their rights under data
                    protection laws to make requests regarding their personal information.</p>



                <p>We are based in the United States and we process and store information on servers located in the
                    United States. By accessing or using the Services or otherwise providing information to us, you
                    consent to the processing, transfer, and storage of information in and to the U.S. and other
                    countries, where you may not have the same rights as you do under local law.</p>
                <p>Additional Information for EEA Users</p>
                <p>Users in the European Economic Area have the right to request access to, rectification of, or erasure
                    of their personal data; to data portability in certain circumstances; to request restriction of
                    processing; to object to processing; and to withdraw consent for processing where they have
                    previously provided consent. EEA users also have the right to lodge a complaint with their local
                    supervisory authority.</p>

                <p>As required by applicable law, we collect and process information about individuals in the EEA only
                    where we have a legal basis for doing so. Our legal bases depend on the Services you use and how you
                    use them. We process your information on the following legal bases:</p>
                <br>
                <ul style="list-style-type: circle;margin-left:30px">
                    <li>You have consented for us to do so for a specific purpose;</li>
                    <li>We need to process the information to provide you the Services, including to operate the
                        Services, provide customer support and personalized features and to protect the safety and
                        security of the Services;</li>
                    <li>It satisfies a legitimate interest (which is not overridden by your data protection interests),
                        such as preventing fraud, ensuring network and information security, enforcing our rules and
                        policies, protecting our legal rights and interests, research and development, personalizing the
                        Services, and marketing and promoting the Services; or</li>
                    <li>We need to process your information to comply with our legal obligations.</li>
                </ul>

                <p>Additional Information for California Users</p>
                <p>The California Consumer Privacy Act (“CCPA”) requires us to provide California residents with some
                    additional information about the categories of personal information we collect and share, where we
                    get that personal information, and how and why we use it.</p>

                <p>In the past year, we collected the following categories of personal information from California
                    residents, depending on the Services used:</p>
                <br>
                <ul style="list-style-type: circle;margin-left:30px">
                    <li>Identifiers, like your TheDojo username, email address, and IP address.</li>
                    <li>Commercial information, including information about transactions you undertake with us.</li>
                    <li>Internet or other electronic network activity information, such as information about your
                        activity on our Services and limited information about your activity on the services of
                        advertisers who use our advertising technology.</li>
                    <li>Audiovisual information in pictures, audio, or video content submitted to TheDojo.</li>
                </ul>

                <p>If you are a California resident, you have additional rights under the CCPA, including the right to
                    request access to or deletion of your personal information, and information about our data
                    practices, as well as the right not to be discriminated against for exercising your privacy rights.
                    These rights can be exercised as described above.</p>
                <br>
                <h4>Children</h4>
                <p>Children under the age of 13 are not allowed to create an account or otherwise use the Services
                    without the consent of a parent or guardian. Additionally, if you are in the EEA, you must be over
                    the age required by the laws of your country to create an account or otherwise use the Services, or
                    we need to have obtained verifiable consent from your parent or legal guardian.</p>
                <br>
                <h4>Changes to This Policy</h4>
                <p>We may change this Privacy Policy from time to time. If the changes, in our sole discretion, are
                    material, we may also notify you by sending an email to the address associated with your account (if
                    you have chosen to provide an email address) or by otherwise providing notice through our Services.
                    We encourage you to review the Privacy Policy whenever you access or use our Services or otherwise
                    interact with us to stay informed about our information practices and the ways you can help protect
                    your privacy. By continuing to use our Services after Privacy Policy changes go into effect, you
                    agree to be bound by the revised policy.</p>
                <br>
                <h4>Contact Us</h4>
                <p>To send a GDPR data subject request or CCPA consumer request, follow the steps in the “Your Rights -
                    Data Subject and Consumer Information Requests” section above.</p>
                <p>If you have other questions about this Privacy Policy, please email us at admin@thedojo.com.</p>
                <br><br>
            </div>
        </div>
    </div>
</main>
@endsection