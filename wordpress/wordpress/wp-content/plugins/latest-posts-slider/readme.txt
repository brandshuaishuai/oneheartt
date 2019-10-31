=== Latest Posts Slider ===
Contributors: rahulevdpl,wpevince
Tags: post slider, category posts slider, display post category wise, carousel post slider, latest posts slider, custom post type slider
Donate link: N/A
Requires at least: 4.0
Tested up to: 5.2
Requires PHP: 5.6
Stable tag: trunk
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Easy way to add and display Latest Posts Slider on your website using a shortcode. Tested with Gutenberg shortcode block.

== Description ==
The Latest Posts Slider plugin is a post slider providing a streamlined user-experience with touch for mobile devices and other responsive devices. The posts slider provides the facility to display recent posts using four attractive designs powered by an owl slider. Also provide the facility to post the slider and set the limit of the slider.

Feel the reality with [DEMO](http://alltime.fit/latest-posts-slider/) with real-time access to the Latest Posts Slider.

Besides that, Latest Posts Slider provides unlimited use slider in the single post with a wide range of options like category, limit, navigation type. 

Not only this but this plugin also works with Gutenberg shortcode block making the customization easy and hassle-free. 

= Here is the list of Latest Posts Slider shortcodes with explanation =

**Main shortcode:** 

[latest-posts-slider]

**To display recent 5 posts:**

[latest-posts-slider limit=5]
Where limit define the number of posts to display.

**If you want to display Latest Posts Slider by category then use this short code:** 

[latest-posts-slider category=category_ID]

= If you want to use the shortcode in template then use this: =
<code><?php echo do_shortcode('[latest-posts-slider]'); ?> </code>

= There are some parameters you can use with Latest Posts Slider shortcode =
[latest-posts-slider]

* **limit** : [latest-posts-slider limit=5] (Display only 5 latest post. By default it display 10 latest posts with shortcode [latest-posts-slider].
 If you want to display all posts then use limit="-1").
* **category**: [latest-posts-slider category=category_ID] ( Display latest posts from perticular category ).
* **show_category_name** : [latest-posts-slider show_category_name=true] (Display category name in post grid. By default value is "false". Other options are "ture OR false").
* **show_date** : [latest-posts-slider show_date=false] (Display post date in post grid. By default value is "false". Other options are "ture OR false")
* **show_content** : [latest-posts-slider show_content=true ] (Display post excert in post grid. By default value is "false". Other options are "ture OR false").
* **Dots and arrows** : [latest-posts-slider dots=false arrows=false]
* **post_type:** [latest-posts-slider post_type=post] (added custom post type support where you add custom post. By default value is "post")
* **show_read_more** [latest-posts-slider show_read_more=true] (Display read more button. Default value in true. Other values are "true OR false")

= Features include: =
* Simple to include.
* Responsive 
* Additionally work with Gutenberg shortcode square. 
* Mouse Draggable. 
* Responsive touch slider.
* You can make numerous post slider with various alternatives at single page or post.
* Custom post type support.

== Installation ==
There are two methods by which you can install the plugin in your site. 

Method 1 (Upload via admin panel):
1. Go to WordPress admin then go to Plugins => Add new => Upload
2. Then select the installable zip file.
3. Upload and active the plugin. After that you can use the shortcode where you want to display the posts slider.

Method 2 (Upload via FTP):
1. Upload the plugin folder to your server plugin directory. Do not upload the zip file. It should be directly the folder.
2. After this, go to WordPress admin and go to Plugins => Installed Plugins
3. If the plugin is successfully uploaded then you will find Latest Posts Slider here.
4. Active the plugin. After that you can use the shortcode where you want to display the posts slider.

== Frequently Asked Questions ==
= How to install the plugin? =
Kindly view the installation tab for the installation process.
= Where can I find the plugin support? = 
You can contact us at wp-support@evincedev.com

== Screenshots ==
1. Latest Posts Slider frontend view
2. Admin shortcode added in page

== Changelog ==
= version 1.1 =
* Added compatiblity of WordPress 5.2

= version 1.0 =
* Initial release

== Upgrade Notice ==
N/A