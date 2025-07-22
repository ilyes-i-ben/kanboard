<div align="center">
  <img src="public/images/logo.svg" width="200" alt="Kanboard Logo" style="background:white; padding:12px; border-radius:8px;">  
  
  # Kanboard
  
  A modern, intuitive project management application built with Laravel
  
  [![Live Demo](https://img.shields.io/badge/Live-Demo-brightgreen?style=for-the-badge)](https://app.kanboard.info)
  [![GitHub](https://img.shields.io/github/license/ilyes-i-ben/kanboard?style=for-the-badge)](https://github.com/ilyes-i-ben/kanboard)
</div>

## 🚀 Quick Start

### Prerequisites
- docker & docker compose (yes, that's all you need!)

### Local Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/ilyes-i-ben/kanboard.git
   cd kanboard
   ```

2. **Start the containers**
   ```bash
   docker compose -f docker-compose.yml -f docker-compose.local.yml up -d
   ```
   we have .local override to differ some deployment specifities from prod

3. **Install deps**
   ```bash
   docker compose exec -u 1000:1000 laravel /bin/bash
   composer install
   npm install
   ```

4. **Database setup**
   ```bash
   # --seed if you want to seed your db with our seeder
   php artisan migrate:fresh --seed
   ```

5. **Start the queue worker (optional) - *started automatically by queue-worker service on prod..***
   ```bash
   php artisan queue:work
   ```

6. **Build assets and start dev server (we use vite)**
   ```bash
   npm run dev 
   ```

## 🛠 Technologies Used

- **Backend & template:** Laravel & Blade template
- **Database:** MySQL db with phpmyadmin 
- **Styling:** tailwindcss

## 🚀 DevOps & Deployment

- **Hosting:** DigitalOcean droplet
- **Containerization:** Dedicated docker compose setup for prod. (check docker-compose.override.yml at droplet branch)
- **Reverse proxy & SSL certs:** all handled by [traefik](https://github.com/traefik/traefik) 

## 📸 Screenshots
![Board View](board-view.png)
![Boards Index](boards-index.png)
![Manage Members](manage-members.png)
![Single Card View](single-card-view.png)
---

<div align="center">
  Made with ❤️ for better project management (welcome to contributions!)
</div>
