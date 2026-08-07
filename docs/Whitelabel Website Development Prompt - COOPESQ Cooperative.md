# Whitelabel Website Development Prompt - COOPESQ Cooperative

## Context

Build a complete whitelabel system for COOPESQ, an Amazonian pisciculture cooperative. The system includes a dynamic public-facing landing page and a full administrative dashboard where every piece of content can be managed by authorized users. The entire site content is database-driven, making it fully whitelabel-capable.

---

## Tech Stack

- **Backend:** Laravel 12+ (PHP 8.2+)
- **Frontend (Public Site):** Vue.js 3 (Composition API) embedded in Laravel via Inertia.js or as SPA
- **Admin Dashboard:** Vue.js 3 with Vue Router and Pinia state management
- **Database:** MySQL
- **Styling:** Tailwind CSS 4+
- **Auth:** Laravel Sanctum for API authentication
- **HTTP Client:** Axios for API communication
- **Rich Text Editor:** Quill or TinyMCE for blog posts
- **File Uploads:** Laravel File Storage or local disk

---

## Color Palette (from COOPESQ brand)

| Color | Hex Code | Usage |
|-------|----------|-------|
| Deep Green | `#1B5E20` | Primary background, headers, footer |
| Bright Orange/Mustard | `#F5A623` | CTAs, highlights, accent elements |
| White | `#FFFFFF` | Text on dark backgrounds, cards |
| Light Green | `#E8F5E9` | Section backgrounds, subtle accents |
| Dark Text | `#1A1A1A` | Body text |

---

## Database Schema (MySQL Migrations)

### Table: `settings`
Stores global site configuration. Columns: `id`, `key` (unique string), `value` (text), `group` (string: general/contacts/socials/seo), `created_at`, `updated_at`. Pre-populated with: site name, mission, vision, values, contact phones, email, Instagram handle, address (Porto Acre - AC, Brasil).

### Table: `pages`
Manages editable static pages. Columns: `id`, `title`, `slug` (unique), `content` (longtext), `meta_description` (text nullable), `meta_keywords` (text nullable), `is_active` (boolean), `order` (integer), `created_at`, `updated_at`.

### Table: `categories`
For products and blog posts. Columns: `id`, `name`, `slug` (unique), `type` (enum: 'product', 'post'), `description` (text nullable), `is_active` (boolean), `created_at`, `updated_at`.

### Table: `products`
Product catalog. Columns: `id`, `name`, `slug` (unique), `category_id` (FK), `description` (text), `image` (string nullable), `is_active` (boolean), `order` (integer), `created_at`, `updated_at`. Categories include: Piscicultura, Frutas Regionais, Raízes, Verduras.

### Table: `posts`
Blog/news articles. Columns: `id`, `title`, `slug` (unique), `category_id` (FK nullable), `content` (longtext), `excerpt` (text nullable), `featured_image` (string nullable), `is_published` (boolean), `published_at` (timestamp nullable), `meta_description` (text nullable), `views` (integer default 0), `created_at`, `updated_at`.

### Table: `partners`
Client/partner logos for "Who We Serve" section. Columns: `id`, `name`, `logo` (string), `url` (string nullable), `is_active` (boolean), `order` (integer), `created_at`, `updated_at`.

### Table: `differentials`
Cards for the "Differentials" section. Columns: `id`, `title`, `description` (text), `icon` (string nullable), `order` (integer), `is_active` (boolean), `created_at`, `updated_at`.

### Table: `hero_banners`
Rotating hero banners. Columns: `id`, `title` (string nullable), `subtitle` (text nullable), `image` (string), `cta_text` (string nullable), `cta_url` (string nullable), `is_active` (boolean), `order` (integer), `created_at`, `updated_at`.

### Table: `users`
Administrative users. Standard Laravel users table with: `id`, `name`, `email` (unique), `password`, `role` (enum: 'admin', 'editor'), `remember_token`, `timestamps`.

### Table: `testimonials`
Cooperative member testimonials. Columns: `id`, `name`, `role` (string), `content` (text), `image` (string nullable), `is_active` (boolean), `order` (integer), `created_at`, `updated_at`.

---

## API Routes (Laravel RESTful)

```
GET    /api/settings             → Public settings (grouped)
GET    /api/pages/{slug}         → Single page content
GET    /api/pages                → All active pages
GET    /api/products             → Paginated products (with category filter)
GET    /api/products/{slug}      → Single product
GET    /api/posts                → Paginated published posts
GET    /api/posts/{slug}         → Single post
GET    /api/partners             → Active partners
GET    /api/differentials        → Active differentials
GET    /api/banners              → Active hero banners
GET    /api/testimonials         → Active testimonials

POST   /api/admin/login          → Admin authentication
POST   /api/admin/settings       → Update settings
POST   /api/admin/pages          → Create page
PUT    /api/admin/pages/{id}     → Update page
DELETE /api/admin/pages/{id}     → Delete page
POST   /api/admin/products       → Create product
PUT    /api/admin/products/{id}  → Update product
DELETE /api/admin/products/{id}  → Delete product
POST   /api/admin/posts          → Create post
PUT    /api/admin/posts/{id}     → Update post
DELETE /api/admin/posts/{id}     → Delete post
POST   /api/admin/partners       → Create partner
PUT    /api/admin/partners/{id}  → Update partner
DELETE /api/admin/partners/{id}  → Delete partner
POST   /api/admin/banners        → Create banner
PUT    /api/admin/banners/{id}   → Update banner
DELETE /api/admin/banners/{id}   → Delete banner
POST   /api/admin/testimonials   → Create testimonial
PUT    /api/admin/testimonials/{id}  → Update testimonial
DELETE /api/admin/testimonials/{id}   → Delete testimonial
POST   /api/admin/upload         → File upload endpoint (multipart)
GET    /api/admin/stats          → Dashboard statistics
POST   /api/admin/users          → Create admin user
PUT    /api/admin/users/{id}     → Update admin user
```

---

## Admin Dashboard Pages (Vue.js Routes)

| Route | Component | Description |
|-------|-----------|-------------|
| `/admin` | DashboardHome | Stats overview (post count, product count, views, recent activity) |
| `/admin/settings` | SettingsEditor | Edit site settings by group (general, contacts, socials, SEO) |
| `/admin/pages` | PagesList | List all pages with edit/delete actions |
| `/admin/pages/create` | PageEditor | Create new page with title, content, SEO fields |
| `/admin/pages/edit/:id` | PageEditor | Edit existing page |
| `/admin/posts` | PostsList | List posts with filters (published/draft), search |
| `/admin/posts/create` | PostEditor | Create post with rich text editor, image upload, category |
| `/admin/posts/edit/:id` | PostEditor | Edit existing post |
| `/admin/products` | ProductsList | List products with category filter |
| `/admin/products/create` | ProductEditor | Create product with image, category, description |
| `/admin/products/edit/:id` | ProductEditor | Edit existing product |
| `/admin/partners` | PartnersList | Grid of partner logos with add/edit/delete |
| `/admin/partners/create` | PartnerEditor | Upload logo, set name and URL |
| `/admin/banners` | BannersList | Manage hero banners with image upload and ordering |
| `/admin/banners/create` | BannerEditor | Create banner with image, title, CTA |
| `/admin/testimonials` | TestimonialsList | Manage cooperative member testimonials |
| `/admin/users` | UsersList | Manage admin users and roles |
| `/admin/login` | Login | Authentication page |

---

## Public Website Sections (Vue.js)

### 1. Header / Navigation
- Sticky navbar with COOPESQ logo on the left.
- Navigation links: Home, Sobre (About), Produtos (Products), Blog, Contato (Contact).
- "Área Restrita" login button on the right.
- Mobile hamburger menu for responsive design.

### 2. Hero Section
- Full-width banner with background image (Amazon rainforest / pisciculture).
- Overlaid text: cooperative tagline and mission statement.
- CTA button: "Conheça a COOPESQ" linking to About section.
- Multiple banners support (rotating if more than one is active).

### 3. About Section ("Sobre a Cooperativa")
- Two-column layout: image on left, text on right.
- Summary of the cooperative's mission and purpose.
- Sub-sections for Missão, Visão, Valores displayed as cards or tabs.

### 4. Differentials Section
- 4 cards in a grid: Produção Sustentável, Capacitação, Apoio Comercial, Inovação.
- Each card with an icon, title, and short description.
- Pulls data from the `differentials` table.

### 5. Products Catalog
- Section title: "Nossos Produtos".
- Grid of product cards with image, name, and category badge.
- Filter tabs by category: Todos, Piscicultura, Frutas, Raízes, Verduras.
- Pagination for large catalogs.
- Pulls from `products` and `categories` tables.

### 6. Who We Serve ("Quem Atendemos")
- Logo grid/carousel of partners and clients.
- Pulls from `partners` table.

### 7. Testimonials Section
- Carousel or grid of cooperative member testimonials.
- Name, role, and quote displayed.
- Pulls from `testimonials` table.

### 8. Blog / News Section
- Section title: "Notícias" or "Publicações".
- Displays the latest 3 published posts as cards (image, title, excerpt, date).
- "Ver Todas" button linking to full blog listing page (`/blog`).

### 9. Blog Listing Page (`/blog`)
- Paginated list of all published posts.
- Search and category filter.
- Click to read full post at `/blog/{slug}`.

### 10. Single Post Page (`/blog/{slug}`)
- Full article with featured image, title, date, content (rich text rendered).
- Share buttons and related posts sidebar.
- SEO meta tags from backend data.

### 11. Contact Section
- Contact info: phones (61) 99576-3665, (69) 99954-7575, (68) 99927-4776.
- Email: coopesqcooperativa@gmail.com
- Instagram: @coopesq
- Address: Porto Acre - AC, Brasil
- Optional: embedded Google Maps iframe or OpenStreetMap.

### 12. Footer
- Deep green background with white text.
- 4 columns: About (short description), Quick Links, Products, Contact.
- Social media icons (Instagram).
- Copyright line: "© 2024 COOPESQ. Todos os direitos reservados."

---

## Design and UX Guidelines

- **Typography:** Use a modern sans-serif font (e.g., Inter or Poppins from Google Fonts).
- **Spacing:** Generous padding and margins for a clean, breathable layout.
- **Cards:** Rounded corners (border-radius: 8-12px), subtle shadows for depth.
- **Transitions:** Smooth hover effects and scroll animations (use CSS transitions, avoid heavy libraries).
- **Images:** All images should have proper alt text for accessibility and SEO.
- **Loading States:** Skeleton loaders or spinners during API data fetching.
- **Error Handling:** User-friendly error messages for failed operations in the dashboard.
- **Responsive:** Mobile-first approach; test breakpoints at 640px, 768px, 1024px, 1280px.

---

## SEO and Performance

- Generate dynamic `<title>` and `<meta description>` tags per page/post from database.
- Implement server-side rendering or static generation for public pages if using Inertia/Laravel SSR.
- Lazy-load images below the fold.
- Cache API responses for public endpoints using Laravel Cache (5-minute TTL).
- Use Laravel's built-in query builder eager loading (`with()`) to avoid N+1 queries.
- Compress images on upload (Laravel Intervention Image package).

---

## Security

- All admin routes must be protected with Laravel Sanctum authentication middleware.
- Validate all inputs server-side using Laravel Form Requests.
- Sanitize HTML content in blog posts and page content before saving (allow safe HTML tags only).
- Use CSRF tokens for all form submissions.
- Implement rate limiting on login and public API endpoints.
- Store uploaded files outside the public directory and serve through Laravel's storage system.

---

## Whitelabel Architecture Notes

The whitelabel capability means that:
- All text content (titles, descriptions, mission, values, contact info) comes from the `settings` and `pages` tables, not hardcoded.
- All images (banners, product photos, partner logos) are stored in the database/file storage and served dynamically.
- The blog, products, partners, and testimonials are all fully managed through the dashboard.
- To adapt this system for another cooperative, the user only needs to: change the logo, update settings via the dashboard, add products, and write posts. No code changes required.
