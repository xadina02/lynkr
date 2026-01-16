# 🛠️ Lynkr Brand Discovery Platform

## 🚀 Getting Started

Follow these steps to run the application locally:

### 📦 Requirements

- PHP >= 8.1
- Composer
- Node.js and NPM
- MySQL or other supported database

---

### ⚙️ Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/xadina02/lynkr.git
   cd lynkr
   ```

2.	**Install PHP Dependencies**
   ```bash
   composer install
   ```

3.	Install JavaScript Dependencies
   ```bash
   npm install
   ```

4.	Create and Configure .env File
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5.	Set Up Your Database
	•	Update .env with your DB credentials
	•	Then run:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6.	Build Assets
   ```bash
   npm run build
   ```

7.	Run the Server
   ```bash
   php artisan serve
   ```


⸻

✅ Done!

Visit ```http://127.0.0.1:8000``` in your browser to explore the app.

Login Credentials
```
Email: admin@lynkr.info
Password: password
```

⸻

📂 Additional Commands
	•	Rebuild assets during development:
   ```bash
   npm run dev
   ```

Clear cache (optional):
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```
⸻
