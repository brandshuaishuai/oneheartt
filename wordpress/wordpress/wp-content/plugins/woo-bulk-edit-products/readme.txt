=== WooCommerce Bulk Edit Products - WP Sheet Editor ===
Contributors: wpsheeteditor,vegacorp,josevega, freemius
Tags: woocommerce, bulk edit, products, spreadsheet, wp sheet editor
Stable tag: 1.0.17
Requires at least: 4.7
Tested up to: 5.2
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Modern Bulk Editor for WooCommerce products, create and edit hundreds of products in a spreadsheet inside wp-admin. No need to export/import

== Description ==
Products Bulk Editor where you can Edit WooCommerce products Quickly and you can bulk create products too.

https://youtube.com/watch?v=ioTU4F8NwbY&showinfo=0

= Use Cases =

* WooCommerce stores : you can view all your products in a single page
* You want to create a lot of products Quickly
* You want to edit products Quickly
* You want to search products by Keyword, Status, Author
* You want to Update Hundreds of products quickly using a spreadsheet
* You want to copy settings from one product into a lot of products
* Products Bulk Editor where you can view all the products in a spreadsheet table

= Free Features =
* You can view and edit simple products only
* You can view all the product information
* You can edit the product title, description, sku, stock quantity, stock status, manage stock, regular price, sale price, and is virtual

= Premium features =

[Buy premium plugin](https://wpsheeteditor.com/go/woocommerce-addon?utm_source=wp.org&utm_medium=web&utm_campaign=products-lite-buy)
**Money back guarantee.** We´ll give you a refund if the plugin doesn´t work.

**Full Product Integration**
Edit all product types, including Simple, Variable, Variations, External products, Subscription products, Membership products, etc.

You can edit all product fields, including Gallery Images, Attributes, Variations, and Custom Fields added by other plugins

* Title
* URL Slug
* Content
* Date
* Modified Date
* Short description
* Status
* Enable reviews
* Featured Image
* Product categories
* Product tags
* Edit attributes
* Type
* SKU
* Regular Price
* Sale Price
* Weight
* Width
* Height
* Length
* Manage stock
* Stock status
* Stock
* Visibility
* Gallery
* Downloadable
* Virtual
* Sales price date from
* Sales price date to
* Sold individually
* is featured?
* Allow backorders
* Purchase note
* Shipping class
* Download limit
* Download expiry
* Download type
* Download files
* Variation description
* Variation enabled?
* Default attributes
* Custom Fields

[Buy premium plugin](https://wpsheeteditor.com/go/woocommerce-addon?utm_source=wp.org&utm_medium=web&utm_campaign=products-lite-buy)
**Money back guarantee.** We´ll give you a refund if the plugin doesn´t work.

**Multiple editors**

You can edit in our spreadsheet inside wp-admin, so all the changes apply live.
You can also edit in Excel or Google Sheets and import the changes easily.

**Perfect for Product Attributes, Variations, and Downloadable Files**

You can view the product variations in the spreadsheet, so you can edit the fields quickly.
You can create variations in bulk in the spreadsheet too.

You can copy product variations and attributes from one product to multiple products. This will save you a lot of time.

You can copy downloadable files from one product to another product, you can update the files in bulk.

**Make Advanced Searches**

You can search by multiple fields and using multiple conditions.
For example, find all products from category "Music" with Stock < 100
Find all products with keyword "Steve" and without images
Find products by date, etc.

You can make searches using any product field and any search operator (<,>,=,<=, >=, LIKE, NOT IN, etc.).

[Buy premium plugin](https://wpsheeteditor.com/go/woocommerce-addon?utm_source=wp.org&utm_medium=web&utm_campaign=products-lite-buy)
**Money back guarantee.** We´ll give you a refund if the plugin doesn´t work.

**Edit thousands of products at once**
We have a formulas engine that lets you update a lot of products quickly.

You can replace values in ANY field:
- Replace brand names in product descriptions
- replace one image in all the products
- replace one category with another for 100 products, etc.

You can do math operations:
- Increase product prices by 20%
- Decrease stock by 10
- Use any math formulas

You can combine fields:
- Copy the "regular price" to the "sale price" field
- Copy information between products
- And more

**Add new fields to the bulk editor**
The bulk editor automatically recognizes all custom fields added by other plugins. You don't need to setup the new fields.
It will show all the fields added by Advanced Custom Fields and any other WooCommerce Extension, so you can start editing right away.

* And more.

[Buy premium plugin](https://wpsheeteditor.com/go/woocommerce-addon?utm_source=wp.org&utm_medium=web&utm_campaign=products-lite-buy)
**Money back guarantee.** We´ll give you a refund if the plugin doesn´t work.

== Installation ==
= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type the plugin name and click Search Plugins. Once you’ve found our plugin you can install it by simply clicking “Install Now”.

= Manual installation =
The manual installation method involves downloading our plugin and uploading it to your webserver via your favourite FTP application. The WordPress codex contains [instructions on how to do this here.](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation)


== Frequently Asked Questions ==
= What user information can I edit? =

The free version lets you edit these fields: product title, description, sku, stock quantity, stock status, manage stock, regular price, sale price, and is virtual
You can view all the fields in the spreadsheet though.

The premium version lets you edit all fields, including custom fields. You can create new columns for editing new fields.

[Buy premium plugin](https://wpsheeteditor.com/go/woocommerce-addon?utm_source=wp.org&utm_medium=web&utm_campaign=products-lite-buy)

= Can I use this plugin on cheap / shared servers? =

Yes. You can set up the number of posts to save per batch and the waiting between batches. Tweaking those settings you can make it work with any server.

== Screenshots ==
1. bulk editor

== Changelog ==
= V 1.0.17 - 2019-09-06 =
Updated to CORE v2.14.0
* NEW - ACF - Add support for gallery field
* NEW - CORE  - Add contextual option: realign cells to fix rare scenarios when cell borders don't match
* NEW - FILTERS - Add option to locate column to save time when searching for a column in the sheet.
* NEW - UNIVERSAL SHEET - IMPORT - Add advanced setting to skip the first N rows, so we can start imports from where we left off
* NEW - WC Products - Add "All" option to the dropdown of global attributes columns, which automatically selects all the options in the dropdown while saving
* NEW - WC Products - Add contextual menu to copy variations from the selected row, which opens the modal and auto-selects the product
* NEW - WC Products - Add contextual menu to create variations for the selected row, which opens the create variations modal and auto-selects the product
* NEW - WC Products - Add the "product_variation" option to the post types column to convert any product into a variation
* NEW - WC Products - Allow to edit the parent product of variations
* CHANGE - CORE - Added internal cache of conversion from file URLs to file IDs to speed up imports and savings
* CHANGE - CORE - Added internal cache of conversion from friendly terms to IDs to speed up imports and savings
* CHANGE - CORE - Free - make the pro columns more subtle, highlight the cell value
* CHANGE - CORE - Show "menu order" column for all post types because some post types use it for unorthodox purposes
* CHANGE - CSV Import - Optimize the reading of CSV files to use less memory and read huge files faster
* CHANGE - POSTS TEMPLATE - when duplicating posts, don't copy the post date, so the new posts have new dates
* CHANGE - SPREADSHEET SETUP - Don't allow to save new custom post types when the custom post types module is not available
* CHANGE - UNIVERSAL SHEET - Delete old csvs when the sheet loads because the cron job doesn't run on rare server setups
* CHANGE - UNIVERSAL SHEET - EXPORT - Add indications at the end of the process to answer questions like download didn't start, where to find the file, when are the files deleted.
* CHANGE - UNIVERSAL SHEET - EXPORT - Optimize the download of large files to use less memory and start faster
* CHANGE - UNIVERSAL SHEET - IMPORT - Add an advanced option to auto-retry failed batches
* CHANGE - WC Products - Free - Enable columns: 'view_post', 'open_wp_editor', 'post_status', 'post_modified', 'post_date', '_length', '_height', '_width', '_weight',
* CHANGE - WC Products - When we add attributes and at least one is "allow for variations", automatically set the product as variable
* CHANGE. UNIVERSAL SHEET. deactivate the rest api by default and add option to settings page to activate manually to avoid compatibility issues with other REST API configurations or external apps.
* FIX - CORE - SERIALIZED FIELDS - When the field contains a single level and subfields have integers as keys, it only shows the value of the first subfield in the cells and the other subfields appear empty
* FIX - CORE - VIEW column has the wrong link when viewing custom post types as a draft
* FIX - FORMULAS - When deleting thousands of rows completely, it only deletes half
* FIX - WC Products - EXPORT - Some column headers when exporting attributes are missing because the first line of the file is not read properly
* FIX - WC Products - Export - Some columns were excluded from the export when it was a custom field used by variations
* FIX - WC Products - Import - Remove the & symbol from the SKU before saving. WC returns a duplicate SKU error when it's not duplicate.
* FIX - WC Products - The internal caches of WC aren't cleared after saving, causing changes not to appear when sites use aggressive cache like wp.com
* FIX - WC Products - When we delete a product completely, we remove the parent row but we should remove the child variation rows as well
* FIX - WC Products - when we edit global attributes in their own columns and change product type from simple to variable at the same time, automatically set the attribute as "used in variation"
* FIX - WC Products > copy variations - When saving meta data in the copied variations, unserialize to prevent double serialization from WP
* FIX - WC Products > create variations > create for every combination of attributes - PHP warning
* FIX. CORE. delete all traces of the plugin on uninstall


= V 1.0.16.1 - 2019-08-11 =
Updated to CORE v2.13.1
* CHANGE - CORE - Make the fancy taxonomy dropdown opt-in as many people prefer the old dropdown to be able to copy paste
* FIX - CUSTOM COLUMNS LITE - Sometimes meta columns were allowed but they were still locked by mistake
* FIX - CORE - Fatal error on REST API endpoints, which breaks the normal post editor
* FIX - CORE - Taxonomy terms can't be updated

= V 1.0.16 - 2019-08-08 =
Updated to CORE v2.13.0
* NEW - CORE - Freeze column titles at the top when scrolling down
* NEW - ADVANCED FILTERS - Add "Length >" and "Length <" operators
* NEW - ADVANCED FILTERS - Add "ends with" operator
* NEW - ADVANCED FILTERS - Add "regex" operator
* NEW - ADVANCED FILTERS - Add "starts with" operator
* NEW - CORE - Fancy multiselect dropdown with autocomplete for taxonomy columns (Added option to settings page to revert to the old type of cell)
* NEW - FILTERS - Accept custom search parameters in the wpse_custom_filters query string
* NEW - FORMULAS - Allow to append files for gallery columns
* NEW - FORMULAS - Allow to prepend files for gallery columns
* NEW - WC Products - Add "edit in spreadsheet" shortcut to the variations list in the normal product editor to quickly launch the spreadsheet editor for those specific variations
INTERNAL - CORE - Allow to disable the image cell zoom by adding ?wpse_no_zoom to the image URL
* CHANGE - Wc Products - Allow to rename the "Download files" column
* CHANGE - Wc Products - Allow to rename the "Variation description"  column
* CHANGE - Wc Products - Allow to rename the "Variation enabled?"  column
* CHANGE - Wc Products - Allow to rename the "Default attributes"  column
* CHANGE - Bulk Edit - When a batch failed and we chose to retry, don't show the server error message
* CHANGE - CORE - Add tip about the taxonomies spreadsheets
* CHANGE - CORE - Automatically update the .pot file for all plugins during the build process for every release
* CHANGE - CORE - Cache the list of taxonomy terms used for cell dropdowns to improve speed on big sites, clear cache when a term is added or the term name, parent, or taxonomy is updated
* CHANGE - CORE - Fix the top bar when we scroll right
* CHANGE - CORE - If the page is RTL, force english as language on the sheet page because the sheet doesn't support RTL
* CHANGE - CORE - Improved the loading of rows. Loading 200 rows takes 40 seconds less.
* CHANGE - CORE - Save - When a batch failed and we chose to retry, don't show the server error message
* CHANGE - CUSTOM POST TYPES - Exclude the post types that have their own spreadsheet to prevent errors
* CHANGE - FORMULAS - After successful execution, if there aren't unsaved changes in the sheet, reload the sheet automatically to show the bulk edits
* CHANGE - FORMULAS - when the popup closes. go back to step 1
* CHANGE - IMPORT - Add an "Unselect all" option above columns mapping
* CHANGE - UNIVERSAL SHEET - IMPORT - After closing the popup from a successful import, auto-reload the sheet if there aren't unsaved changes
* CHANGE - WC Products > copy variations - The progress log becomes too long
* CHANGE - YOAST - Load the primary category dropdown via ajax to make the sheet load faster
* CHANGE- CORE - Moved all the media library code to a separate spreadsheet plugin
* FIX - CORE - Clear the object cache automatically when the data source changes (i.e. when categories are added or created) to prevent issues with persistent object cache setups
* FIX - CORE - It doesn't load more rows when we scroll to the bottom
* FIX - CORE - The sheet doesn't save changes if the post IDs are too high (i.e. 999988878978)
* FIX - CORE - make it work with the classic editor plugin (our compatibility broke with the recent update of the classic editor)
* FIX - FORMULAS - When editing a taxonomy column using append/prepend, use the taxonomy term separator from the settings page
* FIX - WC Products - Bulk Edit tool doesn't show the "Default attributes" column
* FIX - WC Products - Bulk Edit tool doesn't show the "downloadable files" column
* FIX - WC Products - Bulk Edit tool doesn't show the "product attributes" column
* FIX - WC Products - When creating new rows in the spreadsheet, create it with draft status
* FIX - WC Products - When editing multiple attribute taxonomies for the same product in the cells, it only attaches to the product the last taxonomy edited
* FIX - WC Products - When publishing drafts, automatically generate the URL slug
* FIX - WC Products - When saving multiple gallery images, it saves them as URLs instead of IDs
* FIX - WC Products > copy variations - it allows to submit without accepting the "I understand..." checkbox
* FIX - CORE - It doesn't save the menu order column

= V 1.0.15 - 2019-07-01 =
* NEW - CORE - Add "share" tool to faciliate user collaboration
* NEW - CORE - Add the option to select the user roles who can access our spreadsheet.
* NEW - CORE - Added option to deactivate the data prefetch
* NEW - CORE - Allow to disable the meta data scan programmatically
* NEW - CORE - allow to rename columns using contextual menu
* NEW - CORE - Allow to rename columns using the columns visibility popup
* NEW - MEDIA - Add column showing the parent post title as readonly
* NEW - UNIVERSAL SHEET - EXPORT - Added option to add CSV compatibility with excel
* NEW - UNIVERSAL SHEET - EXPORT - Added option to select all active columns
* NEW - WC Products - Allow to edit custom fields on variation rows
* CHANGE - CORE - When a toolbar is disabled, automatically stop rendering the related popup content
* CHANGE - MEDIA - Remove the "add new" tool
* CHANGE - USERS - If the current user can edit, the default query shouldn't have the role__in query parameter, it should load all roles
* CHANGE - WC Products - Import - Automatically map the "meta: " columns
* CHANGE - WC Products - Import - When there is an error, indicate the row that contains the error
* FIX - CORE - Disable wpautop when using gutenberg because it breaks the block markup
* FIX - FILTERS - Search by author doesn't work (the author dropdown has wrong user ids)
* FIX - FORMULAS - The column placeholders don't work for columns that use the get_value callback
* FIX - GLOBAL - Sometimes when we use the free plugin and activate the premium plugin, the license activation screen doesn't appear and the user doesn't know how to activate it
* FIX - MEDIA - fix the preview column to show the thumbnail and large image on hover
* FIX - UNIVERSAL SHEET - CSV reading - It doesn't work when "fopen(): data:// wrapper" is disabled in the server
* FIX - UNIVERSAL SHEET - Export - It fails when column headers count doesn't match the column values count in a row
* FIX - UNIVERSAL SHEET - EXPORT - It links directly to the CSV file which just displays the content instead of downloading it
* FIX - UNIVERSAL SHEET - IMPORT - CSVs that contain &quot can't be read
* FIX - WC Products - Export - The columns coming from the WC CORE api are duplicated starting from batch 2
* FIX - WC Products - Import - Optimize the auto mapping of columns to avoid using too much memory when we have too many columns
* FIX - WC Products - Import - Sometimes we end up with ghost products created by WC Core, auto delete them
* FIX - WC Products - Import - The "Import as meta" option in the columns mapping wasn't working

[See full changelog.](https://wpsheeteditor.com/changelog/?utm_source=wp.org&utm_medium=web&utm_campaign=products-lite-changelog)