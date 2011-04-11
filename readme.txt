=== Delete Me ===
Contributors: clintcaldwell
Donate link: http://www.clintcaldwell.com/donate/wordpress-plugin-delete-me.php
Tags: delete, user delete, delete profile, user management
Requires: WordPress 3.0+, PHP 5.2+
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 1.0

Allow specific WordPress roles ( except administrator ) to delete themselves.

== Description ==

Allow specific WordPress roles ( except administrator ) to delete themselves on the `Users -> Your Profile` subpanel or
on any Post or Page using the Shortcode `[plugin_delete_me /]`. Settings for this plugin are found on the `Settings -> Delete Me` subpanel.

How it works:

* A user clicks the delete link, which by default says `Delete Profile`, but can be changed.

* User is prompted to confirm they want to delete themselves ( OK | Cancel ).

* If ( OK ) the user is deleted along with all their Posts and Links.

* Deleted user is redirected to the landing page URL, which by default is your home page, but can be changed.

Settings available:

* Select specific WordPress roles ( e.g. Subscriber, Contributor, etc. ) you want to allow to delete themselves using Delete Me.

* `class` and `style` attributes of the delete link.

* `<a>` tag clickable content ( i.e. text, image, both ) of the delete link.

* Landing page URL ( i.e. where deleted users are redirected ).

* E-mail notification when a user deletes themselves.

== Installation ==

1. Install automatically in WordPress on the `Plugins -> Add New` subpanel or upload the `delete-me` folder to the `/wp-content/plugins/` directory.

2. Activate the plugin on the `Plugins` panel in WordPress.

3. Go to the `Settings -> Delete Me` subpanel. Select the WordPress roles you want to allow to delete themselves using Delete Me and save changes.

4. The delete link will be placed automatically on the `Users -> Your Profile` subpanel for roles you allow, but if you have a Post or Page you'd like the delete link to appear on just copy and paste the Shortcode `[plugin_delete_me /]` there. 

== Frequently Asked Questions ==

= What happens to Posts and Links belonging to a deleted user? =

They're also deleted since the user deleting themselves will not be an administrator, and thus the option of reassignment unavailable.
Note: Pages are considered Posts ( i.e. post_type=page ) and any Pages belonging to the deleted user will also be deleted.

= Is it possible for a user to delete anyone but themselves? =

Absolutely not, the user deleted is only the currently logged in user, period.

= What does the Shortcode display when the user is not logged in or their role is not allowed to delete themselves? =

a) Nothing when using the self-closing Shortcode tag ( i.e. `[plugin_delete_me /]` ).
b) However, when using the opening and closing Shortcode tags ( i.e. `[plugin_delete_me]` Content `[/plugin_delete_me]` ) the content inside the tags will appear instead of the delete link.

= Where is a user sent after deleting themselves? =

The `Settings -> Delete Me` subpanel lets you enter any URL you'd like to redirect deleted users to, set to home page by default.

= Is there any confirmation prompt before the user deletes themselves? =

Yes, users are prompted to confirm by Javascript dialog ( OK | Cancel ).

= Does this plugin support WordPress Multisite? =

No. The plugin will not load if WordPress Mulisite is detected. If I have alot of requests for Multisite support I'll consider adding it.

= Is this plugin available in any languages other than English? =

No. If I have alot of requests for localization I'll consider adding some.

== Screenshots ==

1. `Users -> Your Profile` subpanel.
2. Post or Page using the Shortcode.
3. `Settings -> Delete Me` subpanel.

== Changelog ==

= 1.1 =

* Added optional email notification.
* Bugfix - Functions wp_delete_post and wp_delete_link undefined error corrected.

= 1.0 =

* Initial release.

== Upgrade Notice ==

= 1.1 =

Added optional email notification.
Bugfix - Functions wp_delete_post and wp_delete_link undefined error corrected. Please upgrade immediately!

= 1.0 =

Initial release.