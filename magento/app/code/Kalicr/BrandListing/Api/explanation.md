# API & Service Contract Architecture (Api/)

The `Api` directory is what makes your module "stable." Other developers don't have to look at your complex Model logic; they only need to look at these interfaces to know how to interact with your Brand module.

## Api/Data/ (The Data Blueprint)
This sub-folder defines what a "Brand" looks like as a data object.

### BrandInterface.php
* **Location:** `Api/Data/BrandInterface.php`
* **Role:** This defines the "Shape" of your data. It lists all the `get` and `set` methods for your entity (e.g., `getName()`, `getIsActive()`).
* **Why it matters:** By using an interface here, you allow Magento's **Web API** (REST/SOAP) to automatically convert your PHP objects into JSON. 
* **Connection:** Your main `Model/Brand.php` MUST implement this interface. This ensures your model follows the rules you set here.

---

## Api/ (The Functional Blueprint)
These interfaces define the **Operations** (the "verbs") that can be performed on your data.

### BrandRepositoryInterface.php
* **Location:** `Api/BrandRepositoryInterface.php`
* **Pattern:** Repository Pattern.
* **Role:** This is the primary way other modules should load or save brands. Instead of using a Factory and loading a model directly, they call `$repository->getById($id)`.
* **Stability:** If you decide to change your database table name or move from MySQL to a flat file, you only update the *Implementation* of the repository. The *Interface* stays the same, so no other code in the store breaks.

### BrandManagementInterface.php
* **Location:** `Api/BrandManagementInterface.php`
* **Role:** While Repositories handle CRUD (Create, Read, Update, Delete), **Management** interfaces handle "Business Logic."
* **Example:** If you needed a method like `toggleBrandStatus($id)` or `getTopSellingBrands()`, you would define them here. It keeps the Repository focused on data storage while this focuses on the "Rules" of the brand system.

---

## The "Magic" of the etc/di.xml Connection
Interfaces can't be instantiated (you can't do `new BrandInterface()`). This is where your **etc/di.xml** comes back into play:
* You use a `<preference>` tag to tell Magento: "Whenever someone asks for `BrandRepositoryInterface`, give them the `Kalicr\BrandListing\Model\BrandRepository` class."