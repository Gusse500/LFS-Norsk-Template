# Responsive Website Template I use on my website. lfs.freding.no

This template provides a responsive website layout using **HTML5**, **CSS Grid**, and **JavaScript** with all scripts and styles local.  
It features a fixed header and footer, a sidebar menu that becomes a hamburger menu on small screens, and a cookie consent mechanism.  
The menu includes links to "Contact Us", "Privacy Statement", and "Cookies" pages. A backend for the contact form is also included.

## Structure

```
website/
├── backend/
│   └── contact.php
├── css/
│   └── style.css
├── img/
│   └── android-chrome-192x192.png
│   └── android-chrome-512x512.png
│   └── apple-touch-icon.png
│   └── favicon.ico
│   └── favicon-16x16.png
│   └── favicon-32x32.png
│   └── logo.png
│   └── site.webmanifest
├── js/
│   ├── main.js
│   └── cookies.js
│   └── exlinks.js
├── pages/
│   ├── contact.html
│   ├── privacy.html
│   └── cookies.html
└── index.html
└── README.md
```

- **backend/**: Contains backend scripts (PHP).
- **css/**: Contains all CSS files.
- **img/**: Contains the logo and favicon images.
- **js/**: Contains all JavaScript files.
- **pages/**: Contains subpages which is fixed in the menu below the line.
- **index.html**: Main entry page.

## Features

- **Responsive CSS Grid layout**: Top (fixed), bottom, menu (left), and main grid areas.
- **Customizable colors** for each grid area.
- **Logo** in header, sized to menu width.
- **Sidebar menu** hides on smaller screens toggle with hamburger icon.
- **Floating cookie consent** remembers approval using browser cookies.
- **Contact page** with backend form handler.

---

## Deployment

- Place the folder structure on your web server.
- Update `img/logo.png` with your own logo.
- Update `img/other files` with your own favicon and change `name` and `short_name` in site.webmanifest.
- Edit menu, colors, and content as needed.
- Ensure PHP is enabled for contact form handling.
- Uncomment <script src="js/exlinks.js"></script> for each page where you want to open external links in new tab.

---