# Model Architecture

## Model Directory
We designate the `Model` directory as the definitive home for all business logic and data manipulation rules within our module. In the Magento 2 architecture, we strictly adhere to the Separation of Concerns principle, ensuring that "Control" (Controllers) and "Presentation" (View) are completely decoupled from "Data" (Model).

* **Purpose:** We place this logic here to ensure modularity and portability. By encapsulating data logic within `Model`, we ensure that the business rules travel with the data structure. If we were to move this module to a different project or use it via an API endpoint instead of a web browser, the logic would remain intact without needing to copy controller or view files.
* **Naming Convention:** We always name this folder `Model` (singular). This indicates that it contains the domain model layer itself, rather than just a collection of files.
* **Additional Components:**
    * **Repositories:** We often include classes like `BrandRepository.php` here. We use repositories to apply the "Repository Pattern," which acts as a stable API facade for saving and loading data. This allows us to bypass direct Model usage, making our code easier to test and more adaptable to future changes.
    * **Service Contracts:** We define Interfaces (PHP Interfaces) here that outline exactly how external systems are allowed to talk to our module, enforcing strict typing and predictable behavior.

## Brand.php (The Data Object)
* **Location:** `Model/Brand.php`
* **Naming:** We deliberately use the **Singular Noun** of the entity it represents. We name it `Brand`, not `Brands`, because when we instantiate this class, we are holding the state of **one single brand** in memory at a specific point in time.
* **Placement:** We place it in the root because it serves as the "face" of our data layer. When other developers, controllers, or API endpoints need to interact with our data structure, this is the primary class they look for. It represents the standard entry point for the entity.
* **Role:** We use this class strictly as a container for data. It handles "Getters" and "Setters" (e.g., `getName()`, `setIsActive()`) and manages the object's data array. We do **not** write SQL queries inside this file; its job is to represent the data, not to fetch it.
* **Connection:** This is the specific object that we populate with form data in `Save.php` before invoking the save command. It inherits from `AbstractModel`, giving it the ability to hold data in memory before persisting it.

## ResourceModel Directory
We create this folder to represent the "Database Layer." We use it to create a hard separation between the *Idea* of a Brand (the Model) and the *Storage* of a Brand (the Database).

* **Separation Logic:** We separate these layers for abstraction. If we decided tomorrow to move our underlying storage from MySQL to Oracle, PostgreSQL, or a NoSQL database, we would only need to rewrite the files in `ResourceModel`. The main `Brand.php` model—and all the code elsewhere in Magento that uses it—would remain completely untouched.

### ResourceModel/Brand.php (The Connector)
* **Location:** `Model/ResourceModel/Brand.php`
* **Naming:** We name it identically to the Model (`Brand`) so that Magento's dependency injection system can automatically link the two. If the model is `Brand`, the resource must be `Brand`.
* **Role:** We use this file to contain the "translation" logic between PHP and SQL. It holds the instructions that tell Magento: "When the Model asks to save, insert a row into the table `kalicr_brandlisting_brand` using the primary key `entity_id`." It extends `AbstractDb` to inherit standard database capabilities.
* **Additional Logic:**
    * **Validation:** We place low-level validation rules here that must run specifically before writing to the database, such as ensuring a URL key is unique or that a foreign key constraint is met.

### ResourceModel/Brand/Collection.php (The List)
* **Location:** `Model/ResourceModel/Brand/Collection.php`
* **Subfolder Organization:** Although Collections are technically part of the ResourceModel layer (because they talk to the DB), they handle *groups* of objects rather than single rows. We place them inside a folder named after the entity (`Brand/`) to keep the namespace clean and organized.
* **Naming:** We use `Collection.php` because it is a reserved standard name in Magento. It signifies that this class is an iterator—a list of items that can be looped through.
* **Role:** We use this as a query builder. It allows the Admin Grid or frontend lists to request "Give me 20 brands, sorted by name, where status is active" without us needing to write raw SQL queries. It loads data "lazily," meaning it doesn't query the database until we actually start using the data.
* **Specialized Collections:**
    * **Grid.php:** In complex scenarios, we might place a specialized `Grid.php` collection here if we need to join multiple tables specifically for the Admin Panel display, separate from the standard frontend collection.

## Brand Subdirectory (Model/Brand/)
We use this as an organizational folder to maintain a clean codebase. As our modules grow in complexity, we cannot simply place every helper file in the root `Model` folder, or it would become unmanageable.

* **Purpose:** We place files here that relate specifically to "Brand" logic but are not the main Model entity itself. It acts as a namespace for support tools specific to this entity.

### DataProvider.php
* **Location:** `Model/Brand/DataProvider.php`
* **Naming:** We name it to implement the specific "DataProvider" pattern required by Magento UI Components. It explicitly "Provides Data" to the frontend/admin forms.
* **Placement:** It is a support class. It is not an entity (Model) and it is not a database mapper (Resource). Since it contains logic *for* the Brand's user interface, we nest it in the `Model/Brand/` subfolder to keep it associated with the entity.
* **Role:** We use this class to bridge the gap between the PHP backend and the JavaScript frontend. It fetches the collection, serializes the data into JSON, and handles specific UI formatting—such as mapping image URLs so the file uploader can display existing images in the Edit form.
* **Related Files:**
    * **ImageUploader.php:** We would place a class here dedicated to moving uploaded brand logos from the temporary folder to the final media folder.
    * **Source Folder:** We often create a `Source` subfolder here containing classes like `Status.php` or `YesNo.php`. These are used to provide the specific options (key-value pairs) for dropdown menus in the admin forms.

## Source Directory
We utilize the `Source` directory (often located within `Model/Source` or `Model/Config/Source`) to house classes that provide specific datasets for user interface elements. In Magento 2, whenever we need to populate a dropdown menu, a multi-select box, or a filter list with dynamic options, we create a dedicated class here.

* **Purpose:** We separate this logic from the main Model to keep our entities clean. While the `Model` cares about *saving* data, the `Source` classes care about *listing* available options for that data.
* **Interface Compliance:** We almost always implement `Magento\Framework\Data\OptionSourceInterface` in these classes. This enforces a standardized `toOptionArray()` method, ensuring that any UI component in Magento can consume our data without knowing where it came from.

### Categories.php
* **Location:** `Model/Source/Categories.php`
* **Naming:** We name this class `Categories` to clearly indicate that it provides a list of category options. It is located in `Source` because it is not an entity itself, but a supplier of options for an entity's attribute.
* **Role:** We use this class to bridge the gap between our Brand module and Magento's native Catalog module. Its sole responsibility is to fetch existing product categories from the database and format them into a simple `label-value` array that the Admin Form can understand.
* **Mechanism:**
    * It injects the `CategoryCollectionFactory` to access Magento's product category data.
    * It filters the results (e.g., excluding the root category or inactive categories) and sorts them alphabetically.
    * It maps the complex Category objects into a lightweight array format: `['value' => '12', 'label' => 'Men's T-Shirts']`.
* **Connection:** This class is directly referenced in our `brandlisting_form.xml`. By defining `<item name="options" xsi:type="object">Kalicr\BrandListing\Model\Source\Categories</item>`, we tell the UI component to instantiate this class and run `toOptionArray()` to populate the dropdown menu automatically.

