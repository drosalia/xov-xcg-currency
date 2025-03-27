
# XOV XCG Currency Plugin

A WordPress plugin that adds the **Caribbean Guilder (XCG)** as a currency for WooCommerce. Supports manual conversion rate setting.

---

## Features
- Adds **Caribbean Guilder (XCG)** as a currency to WooCommerce.
- Allows setting a **manual conversion rate** via the WordPress admin panel.
- Properly displays the currency symbol `Cg` with a space (`Cg 10.00`).
- Ensures compatibility with all WooCommerce pages (Product, Cart, Checkout, Invoices).
- Prevents double conversion by only applying conversion if the WooCommerce currency is **not** set to `XCG`.
- PHPUnit tests to verify currency formatting and conversion handling.
---

## Installation
### Manual Installation
1. **Download the Plugin**
   - Clone the repository or download it as a ZIP file.

2. **Upload to WordPress**
   - Upload the folder `xov-xcg-currency-plugin` to your `/wp-content/plugins/` directory.

3. **Activate the Plugin**
   - Go to **WordPress Admin > Plugins** and activate **XOV XCG Currency**.

---

## Configuration

1. Go to **Settings > XCG Currency** in the WordPress admin panel.
2. Set the conversion rate (e.g., `1.82` for `1 USD = Cg 1.82`).
3. Save changes.

---

## Usage

1. Go to **WooCommerce > Settings > General > Currency Options**.
2. Set the **Currency** dropdown to `Caribbean Guilder (XCG)`.
3. All prices will now be displayed with the `Cg` symbol.

---

## Setting Up The Docker Test Site (For Development & Testing)

The plugin includes a Docker environment to help you test everything locally. Here's how to get started:

---

### Building & Running The Docker Containers

1. **Build the Environment:**
```
docker-compose build
```

2. **Start the Containers:**
```
docker-compose up -d
```

3. **Access WordPress:**
   - Visit: **[http://localhost:8080](http://localhost:8080)**
   - Login credentials:
      - Username: `admin`
      - Password: `password`

4. **Access phpMyAdmin (For Database Management):**
   - Visit: **[http://localhost:8081](http://localhost:8081)**
   - Server: `db`
   - Username: `user`
   - Password: `password`

---

### Important Commands

- **Stop and Remove Containers & Volumes:**
```
docker-compose down -v
```

- **Rebuild Everything (If Changes Are Made):**
```
docker-compose build
```

- **Start Fresh Containers (With Persistent Data):**
```
docker-compose up -d
```

---

## Testing (Using PHPUnit)

The plugin includes PHPUnit tests to ensure everything is working correctly.

---

### Running Tests
1. **Ensure Docker Containers Are Running:**
```
docker-compose up -d
```

2. **Install Composer Dependencies:**
```
docker exec -it <wordpress-container-name> composer install
```

3. **Run PHPUnit Tests:**
```
docker exec -it <wordpress-container-name> phpunit --configuration /var/www/html/wp-content/plugins/xov-xcg-currency-plugin/tests/phpunit.xml
```

4. **Check Test Results:**  
   The results will be displayed in your terminal. Make sure all tests pass before proceeding.

---

## License

MIT License. See the [LICENSE](LICENSE) file for details.

---

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

---

## Contact

For support or inquiries, please contact **Ten-O-5 B.V.** via your preferred communication channels.
