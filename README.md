# Bicycle Shop

## Overview
This project is a simplified e-commerce platform that enables users to customize and add to cart a bike. It also features an admin area for managing customization options.

**Key features:**

**Store front:**
- An interactive bicycle customization tool with configurable options (e.g., frame type, wheels, colors, etc.).
- Real-time price updates based on user selections.
- An “Add to Cart” button that validates configurations before adding them to the cart.
- Clear error messages for invalid part combinations.

**Admin interface:**
- Manage available bicycle parts and customization options.
- Set base prices and define combination-specific pricing.
- Configure rules for allowed and forbidden part combinations.

It was developed as part of a technical assignment.

## Live Demo
In order to save reviewers time, a demo version is deployed here for testing:
[https://bike-shop.gergonzalez.es/products/1](https://bike-shop.gergonzalez.es/products/1)

---

## Stack
- **Languages:** PHP 8, Javascript
- **Main Frameworks:** Laravel 11, Vue.js 3, TailwindCss
- **Main Libraries:** Inertia
- **Database:** Mysql
- **Main Dependecies:** Composer, Npm

---

## Setup Instructions

1. Clone this repository:
```
git clone git@github.com:lostinvader/bicycle-shop.git
```

2. Duplicate .env.example, rename it to .env and update your mysql config:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bycicle_shop
DB_USERNAME=root
DB_PASSWORD=
```

3. Install dependencies:
```
composer install && npm install
```
4. Run Migrations and seeder:
```
php artisan migrate --seed
```
5. Run the application:
```
composer run dev
```
6.	Access the app:
[http://127.0.0.1:8000](http://127.0.0.1:8000).

More info:

https://laravel.com/docs/11.x


## Key Design Decisions

1. **Framework Choice.** Laravel was chosen for its familiarity and simplicity. It provides a lot of out-of-the-box functionalities that reduce development time, making it an excellent choice for this project. 

2. **Monolithic Structure.** Due to time constraints, adopting a SPA approach that consumes content directly from an API was not feasible. The project adopts a monolithic structure, combining Laravel for the backend and Vue.js for the frontend using Inertia.js library. This approach enables the development of fully client-side rendered single-page applications while retaining the simplicity of the monolithic structure.

3. **Database Technology.** A relational dabatase like MySQL was selected for its familiarity and ability to meet the project’s performance and scalability requirements.

4. **Database Design**
- **Products Table:** Stores data about products (e.g., bicycles).
- **Parts Table:** Stores product parts (e.g., frame, color, etc.). Each product can have multiple parts, but each part is associated with only one product.
- **Variants Table:** Stores variations of parts (e.g., Frame -> Diamond, Suspension; Color -> Red, Blue). Each part can have multiple variants, but each variant belongs to only one part.
- **Variant_Variant Table (Intermediate Table):** Acts as a intermemediate table for the Many to Many relationship between the variants and uses pivot records to store this data.

5. **Repositories.** Implemented a repository pattern to decouple Eloquent models from the application logic, making the codebase more maintainable and less dependent on the framework.

6. **Custom Rules.** Used Laravel custom rules to handle the form validation.

## Usage
The project is organized into two main sections:

### Store Front
Due to time constraints, only the single product page has been implemented.

**Single Product Page**
```
URL: /products/{id}
```
<img src="https://img.gergonzalez.es/screen3.png" width="400" alt="Store Front">

This page allows users to customize a product by selecting from the available parts and options.

### Admin Area
Due to time constraints, only the functionality for viewing and editing variants has been added.

While outside the initial scope, Laravel Breeze was utilized to implement authentication out of the box.

User:
```
email: test@example.com
password: password
```

**Variants Page**
```
URL: /admin/variants
```
<img src="https://img.gergonzalez.es/screen1.png" width="400" alt="Store Front">

This page allows administrators to view all available variants and manage them individually.

**Edit Variants Page**
```
URL: /admin/variants/{id}/edit
```
<img src="https://img.gergonzalez.es/screen2.png" width="400" alt="Store Front">

This page provides an interface for editing individual product variants and managing their relationships with other variants.

## Challenges and Solutions
1. **Time Constraints.** The limited time available was the biggest challenge, making it difficult to arrive at the most optimal approaches and solutions. For this reason, I chose to stick with Laravel, as it offers a lot of out-of-the-box features like authorization, validation, etc. Additionally, I utilized TailwindUI for the design, which significantly reduced the design time.

2. **Complex Variant Relationships.** Managing and validating the various options across the variants was challenging, particularly when ensuring that all configurations were valid and secure. Several approaches were considered, such as relying entirely on server-side validation, which would involve making a request each time a variant was selected, that would ensure the client-side data was updated more often on the front end. However, this approach was discarded to enhance performance and reduce the number of requests to our server and database. Instead, we opted for a client-side validation to check the selected options and a server-side validation during the purchase process to ensure the data from client-side was not tampered or outdated.

3. **Scalability and Code Maintenance.** Tried prioritize simplicity and readability, but given the complex relationships between variations and the limited time available, some validations became difficult to follow, resulting in a lot of nested foreach loops, etc. From an architectural perspective, I heavely rely on Laravel framework. However, I made strides in the area such as using a Repository to decouple Eloquent models, this way reduces codebase’s dependence on the framework. 

## Future Improvements
Due to the time limitations the following features weren't implemented:

**From a technical standpoint**
- Enhance validation mechanisms both on the client and server sides. For instance, on the server side, I was unable to finish the price-check validation to ensure the pricing data received from the client was neither tampered with nor outdated. This validation would confirm that the pricing remains accurate and aligns with the latest data fetched prior to processing.
- Refine validation logic for better readability and efficiency. For instance, on server side, leveraging on SQL for complex variants checks.
- Significantly enhance the frontend by addressing various improvements, for example, separate local validation from the view. Introduce a state management library, such as Pinia, to streamline state handling.
- Add tests.
- Implement an API.

**From a functionality standpoint**
- Improve the variants selection area in the single product page by incorporating features such as displaying variants images and providing a real-time preview of the customized bike as options are selected.
- Landing page.
- Product listing page with multiple bicycles featuring filtering and sorting.
- Shopping cart functionality.
- Stock management.
- Full cms CRUD to create, update and delete bicycle, parts and variants.

## Contact
If you have any questions or feedback, feel free to reach out:

- Email: [ger@gergonzalez.com](ger@gergonzalez.com)
- GitHub: [github.com/gergonzalez](github.com/gergonzalez)
- LinkedIn: [linkedin.com/in/gergonzalez](linkedin.com/in/gergonzalez)

## License
Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
