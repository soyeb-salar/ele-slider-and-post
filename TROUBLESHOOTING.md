# Troubleshooting Guide - Ele Slider and Post Addon

## 🚨 Error: "Cannot redeclare control with same name"

If you're seeing this error:
```
PHP Notice: Function Elementor\Controls_Manager::add_control_to_stack was called incorrectly. 
Cannot redeclare control with same name "global_style_section".
```

This is a **caching issue** where WordPress/Elementor is still using an old version of the widget files.

## 🔧 Quick Fix Solutions

### Solution 1: Use the Cache Clear Helper (Recommended)

1. Upload the `cache-clear-helper.php` file to your WordPress root directory
2. Access it via: `yoursite.com/cache-clear-helper.php?clear_cache=eleslider_fix`
3. Follow the instructions on the page
4. **Delete the helper file after use** for security

### Solution 2: Manual Cache Clearing

1. **Deactivate and Reactivate the Plugin**
   - Go to `Plugins > Installed Plugins`
   - Deactivate "Ele Slider and Post Addon"
   - Wait 5 seconds
   - Reactivate the plugin

2. **Clear Elementor Cache**
   - Go to `Elementor > Tools`
   - Click "Regenerate CSS & Data"
   - Click "Sync Library" 

3. **Clear WordPress Cache**
   - If using caching plugins (WP Rocket, W3 Total Cache, etc.), clear their cache
   - If using server-level caching, clear that too

4. **Clear Browser Cache**
   - Hard refresh your browser (`Ctrl+F5` or `Cmd+Shift+R`)
   - Or open an incognito/private window

### Solution 3: Force File Refresh

1. **Edit the main plugin file**
   - Open `ele-slider-and-post-addon.php`
   - Change the version number (e.g., from `2.0.1` to `2.0.2`)
   - Save the file

2. **This forces WordPress to reload all files**

### Solution 4: Remove Old Widget Files (Advanced)

If you have access to FTP/cPanel:

1. **Backup your site first!**
2. Navigate to `/wp-content/plugins/ele-slider-and-post-addon/`
3. Delete the `widgets/` folder
4. Re-upload the updated `widgets/` folder
5. Deactivate and reactivate the plugin

## 🔍 Verification Steps

After trying the solutions:

1. **Check for Errors**
   - Enable WordPress debug: Add `define('WP_DEBUG', true);` to `wp-config.php`
   - Check the error logs for any remaining issues

2. **Test the Widgets**
   - Open Elementor editor
   - Look for "Ele Kit" category in the widgets panel
   - Try adding each widget to ensure they work

3. **Verify Class Names**
   - The widgets should use these class names:
     - `EleSlider_Slider_Widget` (not `EleSlider_slider_Widget`)
     - `EleSlider_Post_Widget`
     - `EleSlider_Slider3_Widget`
     - `EleSlider_Slider4_Widget`

## 🚀 Prevention Tips

1. **Always clear cache after plugin updates**
2. **Don't edit plugin files directly** - use child themes or custom plugins
3. **Keep backups** before making changes
4. **Test on staging sites** first

## 📋 Common Error Messages & Solutions

### Error: `_register_controls() is deprecated`
**Solution**: This indicates old widget files are still cached. Follow Solution 1 above.

### Error: `Class 'EleSlider_slider_Widget' not found`
**Solution**: Clear all caches and regenerate Elementor data.

### Error: `Cannot redeclare class`
**Solution**: There are duplicate class definitions. Check for old backup files in the plugin directory.

## 🆘 Still Having Issues?

If none of the above solutions work:

1. **Check Plugin Conflicts**
   - Deactivate all other plugins temporarily
   - Test if the error persists
   - Reactivate plugins one by one to find conflicts

2. **Check Theme Compatibility**
   - Switch to a default WordPress theme (Twenty Twenty-Three)
   - Test if the error persists

3. **Server Environment**
   - Ensure PHP version is 7.4 or higher
   - Check if OPcache is enabled and clear it
   - Verify file permissions are correct (644 for files, 755 for folders)

4. **Fresh Installation**
   - Delete the plugin completely
   - Download a fresh copy
   - Install and activate

## 📞 Support Information

- **Plugin Version**: 2.0.1
- **WordPress Compatibility**: 5.6+
- **PHP Compatibility**: 7.4+
- **Elementor Compatibility**: 3.0.0+

## 🔄 Version History

- **2.0.1**: Added cache clearing and improved widget registration
- **2.0.0**: Complete rewrite with modern standards
- **1.0.0**: Initial version (deprecated)

---

**Remember**: Always backup your site before making changes!