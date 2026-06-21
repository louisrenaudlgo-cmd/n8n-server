<?php
// Generates a placeholder screenshot for the theme selector.
// In production replace with a real 1200×900 PNG at screenshot.png
header('Content-Type: image/svg+xml');
echo '<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="900" viewBox="0 0 1200 900">'
   . '<rect width="1200" height="900" fill="#0d2c6b"/>'
   . '<rect y="80" width="1200" height="260" fill="#163e9a"/>'
   . '<text x="600" y="230" text-anchor="middle" font-family="sans-serif" font-size="48" fill="#00c8e8" font-weight="bold">OCA</text>'
   . '<text x="600" y="280" text-anchor="middle" font-family="sans-serif" font-size="18" fill="rgba(255,255,255,.7)">Observatoire Citoyen de l\'Audiovisuel</text>'
   . '<rect y="340" width="1200" height="5" fill="#d42b2b"/>'
   . '</svg>';
