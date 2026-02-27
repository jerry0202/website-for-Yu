# Mediascope WordPress Theme

A professional WordPress theme cloned from the Mediascope website (https://www.mediascope.co.in/). This theme is designed for media companies, advertising agencies, and marketing firms.

## Features

- **Responsive Design**: Fully responsive layout that works on all devices
- **Custom Post Types**: Case Studies and Team Members
- **Theme Customizer**: Easy customization through WordPress Customizer
- **Contact Form**: Built-in contact form with email notifications
- **SEO Friendly**: Clean code structure optimized for search engines
- **Fast Loading**: Optimized CSS and JavaScript for fast page loads
- **Modern Design**: Clean, professional design with smooth animations

## Sections Included

1. **Hero Section**: Full-screen hero with background image and call-to-action
2. **About Section**: Company introduction with buttons
3. **Case Studies**: Showcase your successful projects
4. **Services**: Display your service offerings
5. **Team**: Introduce your management team
6. **Insights**: Latest news and blog posts
7. **Contact Form**: Professional contact form with multiple fields
8. **Footer**: Multi-column footer with social links

## Installation

### Method 1: Via WordPress Admin

1. Download the theme as a ZIP file
2. Go to WordPress Admin > Appearance > Themes
3. Click "Add New" and then "Upload Theme"
4. Choose the ZIP file and click "Install Now"
5. Activate the theme

### Method 2: Via FTP

1. Extract the theme files
2. Upload the `mediascope-theme` folder to `/wp-content/themes/`
3. Go to WordPress Admin > Appearance > Themes
4. Activate the Mediascope theme

## Configuration

### 1. Set Up Menus

Go to **Appearance > Menus** and create menus for:
- Primary Menu (Main navigation)
- Footer Menu 1 (Quick Links)
- Footer Menu 2 (Resources)
- Footer Menu 3 (Legal)

### 2. Customize Theme

Go to **Appearance > Customize** to configure:

#### Hero Section
- Hero Title
- Hero Subtitle
- Button Text and URL
- Background Image

#### About Section
- About Title
- About Subtitle
- About Content
- Button URLs

#### Social Links
- Facebook URL
- Twitter URL
- LinkedIn URL
- Instagram URL

### 3. Add Content

#### Case Studies
1. Go to **Case Studies > Add New**
2. Add title, content, and featured image
3. Publish

#### Team Members
1. Go to **Team Members > Add New**
2. Add name, position (in the Position meta box), bio, and photo
3. Publish

#### Blog Posts
1. Go to **Posts > Add New**
2. Add title, content, and featured image
3. Assign to "Insights" category for display on homepage
4. Publish

### 4. Create Pages

Create the following pages for navigation:
- About
- Media
- Solutions
- Insights (Blog page)
- Case Study (Archive page)
- Contact

## File Structure

```
mediascope-theme/
├── assets/
│   ├── js/
│   │   └── main.js          # Theme JavaScript
│   └── images/              # Theme images
├── style.css                # Main stylesheet
├── index.php               # Homepage template
├── header.php              # Header template
├── footer.php              # Footer template
├── page.php                # Page template
├── single.php              # Single post template
├── archive.php             # Archive template
├── functions.php           # Theme functions
├── screenshot.png          # Theme screenshot
└── README.md              # This file
```

## Customization

### Colors

Edit `style.css` and modify CSS variables in the `:root` selector:

```css
:root {
    --primary-color: #1a1a1a;
    --accent-color: #c9a227;
    /* ... other variables */
}
```

### Fonts

The theme uses Google Fonts (Inter and Playfair Display). To change fonts:

1. Edit `header.php` and update the Google Fonts link
2. Update font-family in `style.css`

### Images

Replace images in the `assets/images/` folder:
- `hero-bg.jpg` - Hero background image
- `team-1.jpg`, `team-2.jpg`, `team-3.jpg` - Team member photos
- `case-study-1.jpg`, `case-study-2.jpg`, `case-study-3.jpg` - Case study images

## Contact Form

The contact form submits to the WordPress admin email. To change this:

1. Edit `functions.php`
2. Find the `mediascope_handle_contact_form` function
3. Update the `$to` variable with your desired email address

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Credits

- Original design: [Mediascope](https://www.mediascope.co.in/)
- Fonts: [Google Fonts](https://fonts.google.com/)
- Icons: [Heroicons](https://heroicons.com/)

## License

This theme is created for educational purposes. Please respect the original website's copyright and terms of use.

## Support

For issues or questions, please contact your developer.

---

**Version**: 1.0.0  
**WordPress Version Required**: 5.0+  
**PHP Version Required**: 7.4+