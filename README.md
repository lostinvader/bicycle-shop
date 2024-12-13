# Bicycle Shop

## Overview
This project is a simplified e-commerce platform that enables users to customize and add to cart a bike. It also features an admin area for managing customization options.

###Key features:

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

---

## Stack
- **Languages:** PHP 8, Javascript
- **Main Frameworks:** Laravel 11, Vue.js 3, TailwindCss
- **Main Libraries:** Inertia
- **Database:** Mysql
- **Main Dependecies:** Composer, Npm

---

## Setup Instructions

1. Clone this repository.

2. Duplicate .env.example, rename it to .env and update it.

3. Install dependencies.
```
composer install
npm run install
```
4. Run Migrations and seeder
```
php artisan migrate --seed
```
5. Run the application:
```
composer run dev
```
6.	Access the app at http://127.0.0.1:8000.

If that doesn't work, you can find more info:

https://laravel.com/docs/11.x


## Key Design Decisions

1. **Framework Choice.** Laravel was chosen for its familiarity, simplicity, and robust features. It provides a lot of out-of-the-box functionalities to decrease development tims, making it ideal for this project. 

2. **Monolithic Structure. ** Due to time constraints, work on an SPA approach with an api was out of reach, in order to try to keep it closer, The project adopts a monolithic structure, combining Laravel for the backend and Vue.js for the frontend using Inertia.js. This approach enables the development of fully client-side rendered single-page applications while retaining the simplicity of the monolithic structure.

3. **Database Design**
- **Products Table:** Stores data about products (e.g., bicycles).
- **Parts Table:** Stores product parts (e.g., frame, color, etc.). Each product can have multiple parts, but each part is associated with only one product.
- **Variants Table:** Stores variations of parts (e.g., Frame -> Diamond, Suspension; Color -> Red, Blue). Each part can have multiple variants, but each variant belongs to only one part.
- **Variant_Variant Table (Intermediate Table):* Acts as a intermemediate table for the Many to Many relationship between the variants and uses pivot records to store this data.

4. **Database Technology**
MySQL was selected for its familiarity and ability to meet the project’s performance and scalability requirements.

5. **Repository Pattern**
Implemented a repository pattern to decouple Eloquent models from the application logic, making the codebase more maintainable and less dependent on the framework.

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

**Products Page**
```
URL: /admins/products
```
<img src="https://img.gergonzalez.es/screen1.png" width="400" alt="Store Front">

This page allows administrators to view all available variants and manage them individually.

**Edit Product Page**
```
URL: /admins/products/{id}/edit
```
<img src="https://img.gergonzalez.es/screen1.png" width="400" alt="Store Front">

This page provides an interface for editing individual product variants and managing their relationships with other variants.

## Challenges and Solutions
1. **Time Constraints.**The limited time available posed a significant challenge, often making it difficult to arrive at the most optimal solutions.

2. **Scalability and Code Maintenance.** Balancing simplicity and readability with future scalability was critical. Overengineering could have easily complicated the codebase, so efforts were made in this area to keep the code simple and maintenable. Using for example Repository Pattern.

3. ** Complex Variant Relationships.** Managing and validating the crazy relationships between different variants was chagelling, especially when ensuring all configurations were valid.


## Future Improvements
Due to the time limitations the following features weren't implemented:
- More validation in client side and server side.
- Product listing page with multiple bicycles.
- Shopping cart functionality.
- Stock management.
- Full cms CRUD to create, update and delete bicycle, parts, etc.

## Contact
If you have any questions or feedback, feel free to reach out:

- Email: ger@gergonzalez.com
- GitHub: github.com/gergonzalez
- LinkedIn: linkedin.com/in/gergonzalez

## License
Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
