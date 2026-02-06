# Block Architecture

## Adminhtml/ (The Admin Management Layer)
In Magento, we don't just hard-code buttons into HTML. We use **Button Providers**. This allows us to inject logic—like "Should this button show up only for certain users?"—without touching the UI Component XML.

### Edit/SaveButton.php
* **Location:** `Block/Adminhtml/Edit/SaveButton.php`
* **Interface:** We implement `ButtonProviderInterface`. This is the standard contract Magento expects when you link a class to a UI Component's button node.
* **Role:** We use this to define the "Save" action metadata. Instead of just being a tag, it returns an array containing the label, CSS classes (`save primary`), and the `mage-init` JS trigger that tells the frontend to submit the form.
* **Why here?:** We place this in `Adminhtml/Edit` because it is specific to the edit/create view of our Brand module.

---

## Widget/ (The Modular Frontend Layer)
When we want to give a merchant the power to drop a "Brand Slider" onto any CMS page without touching code, we create a **Widget Block**.

### BrandSlider.php
* **Location:** `Block/Widget/BrandSlider.php`
* **Inheritance:** We extend `Template` so we can render a `.phtml` file, and we implement `BlockInterface` so the Magento Widget engine recognizes it.
* **The "Bridge" Role:** This class is the middleman. It asks the **CollectionFactory** for data and passes it to the template.

#### Logic & Connections:
* **Template Mapping:** We define `$_template = "widget/brand_slider.phtml"`. This tells Magento: "When this block runs, look in `view/frontend/templates/widget/` for the HTML".
* **Data Fetching (`getBrands`):** Notice we aren't writing SQL. We create a collection, filter for `is_active = 1`, and ensure a logo exists. We also pull `$this->getData('brands_limit')`, which is a value the admin types into the widget configuration.
* **URL Generation:** We inject `StoreManagerInterface` to handle the `getLogoUrl()` method. We never hard-code paths; we ask the Store Manager for the base Media URL to ensure the images work across different environments (local, staging, production).

#### How we can change this:
* **Feature Idea:** If we wanted to show "Featured Brands" first, we would add a new `addFieldToFilter` in `getBrands()` based on a boolean attribute in our database.
* **Flexibility:** Since this is a Widget, we could add more `getData()` calls to allow the admin to choose between a "Slider" or a "Grid" layout directly from the CMS interface.