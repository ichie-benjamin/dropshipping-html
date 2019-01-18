=== GDPR Cookie Compliance ===
Contributors: MooveAgency
Donate link: https://www.mooveagency.com/wordpress-plugins/
Stable tag: trunk
Tags: gdpr, compliance, cookies, eu, regulations, european union
Requires at least: 4.5
Tested up to: 5.0
Requires PHP: 5.6
License: GPLv2

GDPR is an EU wide legislation that specifies how user data should be handled. This plugin has settings that can assist you with GDPR cookie compliance requirements.

== Description ==

### What is GDPR?

General Data Protection Regulation (GDPR) is a European regulation to strengthen and unify the data protection of EU citizens. ([https://www.eugdpr.org/](https://www.eugdpr.org/))

### How this plugin works

* This plugin is designed to help you prepare your website for the GDPR regulations related to cookies but IT WILL NOT MAKE IT FULLY COMPLIANT - this plugin is just a template and needs to be setup by your developer in order to work properly.
* Once installed, the plugin gives you a template that you can customise; you can modify all text and colours to suit your needs.
* You can also allow users to enable and disable cookies on your site, however, this will require bespoke development work as every site is unique and uses different cookies.

### Key features

* Full customisation - upload your brand colours, logo, fonts and modify all text
* Flexible - decide which scripts will be loaded by default or only when the user gives consent
* Two layouts - choose from two unique layouts
* Simple & Intuitive
* **[Premium]** Full-screen layout - If it's enabled, the Cookie Banner will be display in full screen mode, and force the user to accept the cookies, or to change / overview the settings.
* **[Premium]** Export & import settings
* **[Premium]** WordPress Multisite extension - You can manage the settings globally, clone from one site to another
* **[Premium]** Accept cookies on scroll
* **[Premium]** Consent Analytics

> Note: some features are part of the **Premium Add-on**. You can [get GDPR Premium Add-on here](https://www.mooveagency.com/wordpress-plugins/)!

### Demo Video

You can view a demo of the plugin here: 

[vimeo https://vimeo.com/255655268]

[GDPR Cookie Compliance Plugin by Moove Agency](https://vimeo.com/255655268)

### Custom Layout

* You can also create your own custom front-end layout of the Pop-up Settings screen.
* Simply copy the "gdpr-modules" folder from the plugin directory to your theme directory. 
* If you do this, your changes will be retained even if you update the plugin in the future. 
* Any customisation should be implemented by experienced developers only.
* We won't be able to provide personalised advice or support for customisations.

#### Disclaimer

* This plugin will require technical support from your developer to ensure that it is implemented correctly on your website.
* This is a general plugin with basic functionality. We advise that you to seek independent legal advice on this topic.
* THIS PLUGIN DOES NOT MAKE YOUR WEBSITE COMPLIANT. YOU ARE RESPONSIBLE FOR ENSURING THAT ALL GDPR REQUIREMENTS ARE MET ON YOUR WEBSITE.

== Frequently Asked Questions ==

= How do I setup your plugin? =
You can setup the plugin in the WordPress CMS -> Settings -> GDPR Cookie. In the general settings, you can setup the branding, and other elements. To add Google Analytics, you can enable the “3rd Party Cookies” tab but selecting the “Turn” radio value to “ON”. At the bottom of the “3rd Party Cookies” tab you’ll find 3 sections to add scripts - choose the section that is appropriate for your script. For Google Analytics, we recommend using the 'Footer' section.

= How can I link to the pop-up settings screen? =
You can use the following link to display the modal window:

[Relative Path - RECOMMENDED]
/#gdpr_cookie_modal

[Absolute Path]
https://www.example.com/#gdpr_cookie_modal
https://www.example.com/your-internal-page/#gdpr_cookie_modal


= Pasted code is not visible when view-source page is viewed. =
Our plugin loads the script with Javascript, and that’s why you can’t find it in the view-source page. You can use the developer console in Chrome browser (Inspect Element feature) and find the scripts.

= Can I use custom code or hooks with your plugin? =
Yes. We have implemented hooks that allow you to implement custom scripts, for some examples see the list of pre-defined hooks here: [https://wordpress.org/support/topic/conditional-php-script/](https://wordpress.org/support/topic/conditional-php-script/)

= Does the plugin support subdomains? =
Unfortunately not, subdomains are treated as separate domains by browsers and we’re unable to change the cookies stored by another domain. If your multisite setup use subdomain version, each subsite will be recognised as a separate domain by the browser and will create cookies for each subdomain.

= Does this plugin block all cookies? =
No. This plugin only restricts cookies for scripts that you have setup in the Settings. If you want to block all cookies, you have to add all scripts that use cookies into the Settings of this plugin. 

= Once I add scripts to this plugin, should I delete them from the website’s code? =
Yes. Once you setup the plugin, you should delete the scripts you uploaded to the plugin from your website’s code to ensure that your scripts are not loaded twice.

= Does this plugin stop all cookies from being stored? =
This plugin is just a template and needs to be setup by your developer in order to work properly. Once setup fully, it will prevent scripts that store cookies from being loaded on users computers until consent is given.
 
= Does this plugin guarantee that I will comply with GDPR law?=
Unfortunately no. This plugin is just a template and needs to be setup by your developer in order to work properly. 

== Installation ==

1. Upload the plugin files to the plugins directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the \'Plugins\' screen in WordPress.
3. Settings are available in the "GDPR Cookie" menu under Settings.
4. Use the Settings screen to configure the plugin.
5. You can link directly to the Cookie Settings on your website using the following: /#gdpr_cookie_modal
6. WPML is supported, switch the language in your CMS and translate the text
7. You can also find list of all pre-defined hooks here: https://wordpress.org/support/topic/conditional-php-script/

== Screenshots ==

1. GDPR Cookie Compliance - Front-end - Privacy Overview
2. GDPR Cookie Compliance - Front-end - Strictly Necessary Cookies
3. GDPR Cookie Compliance - Front-end - 3rd Party Cookies
4. GDPR Cookie Compliance - Front-end - Additional Cookies
5. GDPR Cookie Compliance - Front-end - Cookie Policy
6. GDPR Cookie Compliance - Front-end - One Page Layout
7. GDPR Cookie Compliance - Front-end - Cookie Banner
8. GDPR Cookie Compliance - Premium Add-on - Front-end - Full-Screen Mode [Premium]
9. GDPR Cookie Compliance - Admin - General Settings
10. GDPR Cookie Compliance - Admin - Banner Settings
11. GDPR Cookie Compliance - Admin - Floating Button
12. GDPR Cookie Compliance - Admin - Privacy Overview
13. GDPR Cookie Compliance - Admin - Strictly Necessary Cookies
14. GDPR Cookie Compliance - Admin - 3rd Party Cookies
15. GDPR Cookie Compliance - Admin - Additional Cookies
16. GDPR Cookie Compliance - Admin - Cookie Policy
17. GDPR Cookie Compliance - Premium Add-on - Admin - Export/Import Settings [Premium] 
18. GDPR Cookie Compliance - Premium Add-on - Admin - Multisite Settings [Premium] 
19. GDPR Cookie Compliance - Premium Add-on - Admin - Full-Screen Mode Settings [Premium] 
20. GDPR Cookie Compliance - Premium Add-on - Admin - Consent Analytics [Premium] 

== Changelog ==
= 1.3.0 =
* PHP Cookie checker implemented
* PHP function to check Strictly Necessary Cookies: "gdpr_cookie_is_accepted( 'strict' )"
* PHP function to check 3rd Party Cookies: "gdpr_cookie_is_accepted( 'thirdparty' )"
* PHP function to check Advanced Cookies: "gdpr_cookie_is_accepted( 'advanced' )"
* Force reload hook added "add_action( 'gdpr_force_reload', '__return_true' )"
* Fixed layout issues in old Safari

= 1.2.6 =
* Added hook to force reload page on accept

= 1.2.5 =
* Javascript code improvements
* Bugfixes

= 1.2.4 =
* Javascript console warning removed


= 1.2.3 =
* Bugfixes

= 1.2.2 =
* IE11 floating issue fixed

= 1.2.1 =
* Improved admin-ajax.php loading by transient
* Fixed checkbox labels by WCAG 2.0
* Added 'gdpr-infobar-visible' class to the body if the Cookie Banner is visible

= 1.2.0 =
* Fixed modules view

= 1.1.9. =
* Fixed default logo 404 issue
* Fixed floating button positioning
* Modal close & floating button conflict resolved
* Duplicate script injection fixed
* Child theme support added to modules view

= 1.1.8. =
* Improved admin screen with premium, donate, support boxes.
* Fixed missing logo issue
* Undefined variable issue fixed
* Bugfixes

= 1.1.7. =
* Fixed "Third party tab" turn off option

= 1.1.6. =
* Fixed closing comment issue
* Fixed missing stylesheet bug

= 1.1.5. =
* Created 'gdpr-modules' folder, including html sections (this could be added to the main theme folder and is customisable)
* Removed !important tags
* Removed font loaded by css if a custom font is selected
* Translations added: Romanian, German, French
* Translation slug updated, allowing users to upload translations to WordPress.org repository

= 1.1.4. =
* Fixed floating button conflict
* Force reload removed on cookie acceptance
* Console warnings fixed

= 1.1.3. =
* Significant improvement to the plugin settings and content upload workflow
* Info bar features were extended
* Improved cookie removal function
* Bugfixes


= 1.1.2. =
* Fixed php EOL errors
* Fixed visual glitches
* Scripts injected to the first page if the checkboxes are always turned on
* Improved cookie removal function
* Added alt tag to logo
* Setting field created to replace font
* One page layout improvements
* Added option to enable cookies by default
* Ability to display change the position of the Cookie Banner (bottom or top)
* Added donation box

= 1.1.1. =
* Fixed missing ttf font files
* Fixed checkbox visibility
* Added forceGet to location.reload
* Accessibility improvements
* Popup open / close improvements

= 1.1.0. =
* Lightbox loaded from local server
* Google fonts loaded from local, @import removed
* Improved functions to remove cookies
* Bugfixes

= 1.0.9. =
* Added One Page layout
* Extended strictly necessary cookies functionality
* the_content conflicts resolved
* Bugfixes

= 1.0.8. =
* Admin colour picker fixed

= 1.0.7. =
* Third party script jump fixed
* Added new warning message if the strictly necessary cookies are not enabled but the user tried to enable other cookies
* Updated admin colour picker
* Qtranslate X support
* Bugfixes

= 1.0.6. =
* Fixed Lity conflict
* Added "postscribe" library

= 1.0.5. =
* Fixed php method declarations and access
* Bugfixes

= 1.0.4. =
* Moved modal content to wp_footer

= 1.0.3. =
* Extended scripts sections with fields to add "<head>" and to "<body>"
* Editable label for "Powered by" text
* Added radio buttons to change the logo position (left, center, right)
* Colour pickers added to customise the floating button
* Fixed Cookie Banner WYSIWYG editor, links are allowed

= 1.0.2. =
* Fixed .pot file.
* Added WPML support.
* Fixed Strictly Necessary tab content.
* Fixed conflicts inside the WYSIWYG editor.

= 1.0.1. =
* Fixed button conflicts.
* Fixed validation for the scripts in tabs.

= 1.0.0. =
* Initial release of the plugin.
