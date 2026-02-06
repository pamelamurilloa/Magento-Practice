# View Architecture

## Adminhtml/ (The Backend UI)
We use this area to define the interface for managing our Brand data. In modern Magento, we lean heavily on **UI Components** (XML-driven interfaces), but we still need PHP classes to bridge the gap.

### SaveButton.php
* **Location:** `Block/Adminhtml/Edit/SaveButton.php`
* [cite_start]**Role:** This class is a "Button Provider"[cite: 2]. [cite_start]Instead of writing a raw `<button>` tag, we return an array of metadata that Magento's UI Component engine uses to render the button at the top of the edit form[cite: 2].
* [cite_start]**Logic:** It defines the CSS class (`save primary`), the label, and a `mage-init` script that triggers a "save" event when clicked[cite: 2].

---

## Frontend/ (The Customer Experience)
This is where we build the "Brand Slider" that actually appears on the website.

### BrandSlider.php (The Widget Block)
* **Location:** `Block/Widget/BrandSlider.php`
* [cite_start]**Role:** This is a specialized Block that implements `BlockInterface` so it can be used as a Widget in the Magento Admin.
* [cite_start]**Data Retrieval:** It uses a `CollectionFactory` to fetch only active brands that actually have a logo uploaded. [cite_start]It also handles the logic for a `brands_limit` setting, which the merchant can set when they place the widget on a page.
* [cite_start]**URL Helper:** It contains a `getLogoUrl()` method that uses the `StoreManager` to build the full path to the brand image stored in the media folder.

### brand_slider.phtml (The HTML Template)
* **Location:** `view/frontend/templates/widget/brand_slider.phtml`
* **Role:** This is our structural HTML. [cite_start]It loops through the brands provided by the Block and renders the image tags[cite: 15, 19, 21].
* [cite_start]**JS Integration:** We use the `data-mage-init` attribute to automatically link this HTML container to our custom JavaScript slider[cite: 18].
* [cite_start]**Security:** We always use `$block->escapeHtml()` and `$block->escapeUrl()` to prevent XSS (Cross-Site Scripting) vulnerabilities when rendering data[cite: 17, 19].

### brand-slider.js (The Interactivity)
* **Location:** `view/frontend/web/js/brand-slider.js`
* **Role:** This is a **RequireJS** module. [cite_start]It loads jQuery and the "Slick" carousel library to transform our static list of images into an interactive slider[cite: 14].
* [cite_start]**Configuration:** It accepts a `config` object from the PHTML file, allowing us to pass settings like `slidesToShow` or `autoplay` directly from PHP to JavaScript[cite: 14].

### _module.less (The Styling)
* **Location:** `view/frontend/web/css/source/_module.less`
* **Role:** This is where we write our styles using LESS. [cite_start]We wrap our code in `& when (@media-common = true)` to ensure these base styles are loaded for both mobile and desktop views.
* [cite_start]**Encapsulation:** We target the `.brand-widget-container` class to ensure our widget looks consistent (centered text, specific margins) without leaking styles into the rest of the website[cite: 27, 28].