```
AgainTycoon
├─ app
│  ├─ Helpers
│  │  ├─ flash.php
│  │  └─ format.php
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ Admin
│  │  │  │  ├─ AdBannerController.php
│  │  │  │  ├─ AdminController.php
│  │  │  │  ├─ AnalyticsController.php
│  │  │  │  ├─ BrandController.php
│  │  │  │  ├─ CatalogController.php
│  │  │  │  ├─ CategoryController.php
│  │  │  │  ├─ CommentController.php
│  │  │  │  ├─ ContentController.php
│  │  │  │  ├─ DashboardController.php
│  │  │  │  ├─ HeroSlideController.php
│  │  │  │  ├─ MediaController.php
│  │  │  │  ├─ OfferController.php
│  │  │  │  ├─ OrderController.php
│  │  │  │  ├─ ProductController.php
│  │  │  │  ├─ ProfileController.php
│  │  │  │  ├─ ReviewController.php
│  │  │  │  ├─ SectionController.php
│  │  │  │  ├─ SettingsController.php
│  │  │  │  └─ UserController.php
│  │  │  ├─ Auth
│  │  │  │  ├─ AuthenticatedSessionController.php
│  │  │  │  ├─ ConfirmablePasswordController.php
│  │  │  │  ├─ EmailVerificationNotificationController.php
│  │  │  │  ├─ EmailVerificationPromptController.php
│  │  │  │  ├─ NewPasswordController.php
│  │  │  │  ├─ PasswordController.php
│  │  │  │  ├─ PasswordResetLinkController.php
│  │  │  │  ├─ RegisteredUserController.php
│  │  │  │  ├─ SocialiteController.php
│  │  │  │  └─ VerifyEmailController.php
│  │  │  ├─ Controller.php
│  │  │  ├─ DashboardController.php
│  │  │  ├─ Frontend
│  │  │  │  ├─ CartController.php
│  │  │  │  ├─ CatalogController.php
│  │  │  │  ├─ CategoryController.php
│  │  │  │  ├─ CheckoutController.php
│  │  │  │  ├─ FooterController.php
│  │  │  │  ├─ HomeController.php
│  │  │  │  ├─ NewsletterController.php
│  │  │  │  ├─ OfferController.php
│  │  │  │  ├─ OrderController.php
│  │  │  │  ├─ ProductController.php
│  │  │  │  ├─ ReviewController.php
│  │  │  │  ├─ SearchController.php
│  │  │  │  └─ WishlistController.php
│  │  │  ├─ OrderController.php
│  │  │  ├─ ProfileController.php
│  │  │  └─ UserController.php
│  │  ├─ Middleware
│  │  │  ├─ CheckAnyRole.php
│  │  │  ├─ PermissionMiddleware.php
│  │  │  ├─ RoleMiddleware.php
│  │  │  └─ SetLocale.php
│  │  ├─ Requests
│  │  │  ├─ Admin
│  │  │  │  ├─ StoreAdBannerRequest.php
│  │  │  │  ├─ StoreCategoryRequest.php
│  │  │  │  ├─ StoreHeroSlideRequest.php
│  │  │  │  ├─ StoreProductRequest.php
│  │  │  │  ├─ StoreSectionRequest.php
│  │  │  │  ├─ UpdateAdBannerRequest.php
│  │  │  │  ├─ UpdateCategoryRequest.php
│  │  │  │  ├─ UpdateHeroSlideRequest.php
│  │  │  │  ├─ UpdateProductRequest.php
│  │  │  │  └─ UpdateSectionRequest.php
│  │  │  ├─ Auth
│  │  │  │  └─ LoginRequest.php
│  │  │  └─ ProfileUpdateRequest.php
│  │  └─ Resources
│  │     ├─ CategoryResource.php
│  │     ├─ FeaturedProductViewResource.php
│  │     ├─ ProductCardViewResource.php
│  │     ├─ ProductDetailsResource.php
│  │     ├─ ProductResource.php
│  │     ├─ ReviewResource.php
│  │     └─ UserResource.php
│  ├─ Models
│  │  ├─ AdBanner.php
│  │  ├─ Address.php
│  │  ├─ Brand.php
│  │  ├─ Cart.php
│  │  ├─ CartItem.php
│  │  ├─ Catalog.php
│  │  ├─ Category.php
│  │  ├─ Footer.php
│  │  ├─ FooterColumn.php
│  │  ├─ FooterLink.php
│  │  ├─ FooterSetting.php
│  │  ├─ HeroSlide.php
│  │  ├─ NewsletterSubscription.php
│  │  ├─ Offer.php
│  │  ├─ OfferProduct.php
│  │  ├─ Order.php
│  │  ├─ OrderItem.php
│  │  ├─ Payment.php
│  │  ├─ Permission.php
│  │  ├─ Product.php
│  │  ├─ Review.php
│  │  ├─ Role.php
│  │  ├─ SearchTerm.php
│  │  ├─ Section.php
│  │  ├─ Transaction.php
│  │  ├─ User.php
│  │  ├─ UserProfile.php
│  │  ├─ UserStory.php
│  │  └─ Wishlist.php
│  ├─ Observers
│  │  ├─ CategoryObserver.php
│  │  └─ ProductObserver.php
│  ├─ Providers
│  │  ├─ AppServiceProvider.php
│  │  ├─ AuthServiceProvider.php
│  │  └─ ViewServiceProvider.php
│  ├─ Services
│  │  ├─ Category
│  │  │  └─ CategoryProductsService.php
│  │  ├─ CheckoutService.php
│  │  ├─ FooterService.php
│  │  ├─ NavigationService.php
│  │  ├─ Offer
│  │  │  └─ OfferService.php
│  │  ├─ PaymentService.php
│  │  ├─ Product
│  │  │  ├─ ActiveProductService.php
│  │  │  ├─ CategoryService.php
│  │  │  ├─ ProductImageService.php
│  │  │  ├─ ProductPricingService.php
│  │  │  ├─ ProductService.php
│  │  │  └─ ProductStockService.php
│  │  ├─ Search
│  │  │  ├─ CategorySearchService.php
│  │  │  └─ ProductSearchService.php
│  │  ├─ SearchService.php
│  │  └─ SearchTermService.php
│  └─ View
│     └─ Components
│        ├─ AdsBanner.php
│        ├─ AppLayout.php
│        ├─ CategorySlider.php
│        ├─ Products.php
│        └─ ProductSlider.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ pac75FF.tmp
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ image-optimizer.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ factories
│  │  ├─ UserFactory.php
│  │  └─ UserProfileFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_user_profiles_table.php
│  │  ├─ 0001_01_01_000002_create_cache_table.php
│  │  ├─ 0001_01_01_000003_create_jobs_table.php
│  │  ├─ 0001_01_01_000004_create_roles_table.php
│  │  ├─ 0001_01_01_000005_create_role_user_table.php
│  │  ├─ 2025_11_03_094055_create_permissions_table.php
│  │  ├─ 2025_11_03_094148_create_permission_role_table.php
│  │  ├─ 2025_12_03_091907_create_categories_table.php
│  │  ├─ 2025_12_03_091908_create_brands_table.php
│  │  ├─ 2025_12_03_091909_create_products_table.php
│  │  ├─ 2025_12_03_091910_create_addresses_table.php
│  │  ├─ 2025_12_03_091917_create_orders_table.php
│  │  ├─ 2025_12_03_094154_create_order_items_table.php
│  │  ├─ 2025_12_04_062101_create_ad_banners_table.php
│  │  ├─ 2025_12_04_101402_create_user_stories_table.php
│  │  ├─ 2025_12_09_052030_create_carts_table.php
│  │  ├─ 2025_12_09_062853_create_reviews_table.php
│  │  ├─ 2025_12_14_084828_create_newsletter_subscriptions_table.php
│  │  ├─ 2025_12_15_054332_create_footers_table.php
│  │  ├─ 2025_12_23_115257_create_offers_table.php
│  │  ├─ 2025_12_24_042544_create_search_terms_table.php
│  │  ├─ 2026_01_01_044618_create_wishlists_table.php
│  │  ├─ 2026_01_11_102453_create_hero_slides_table.php
│  │  ├─ 2026_01_24_100342_create_payments_table.php
│  │  ├─ 2026_01_24_100454_create_transactions_table.php
│  │  ├─ 2026_02_24_072316_create_sections_table.php
│  │  ├─ 2026_02_24_072317_create_section_banners_table.php
│  │  └─ 2026_02_25_082551_create_catalogs_table.php
│  └─ seeders
│     ├─ DatabaseSeeder.php
│     ├─ RolePermissionSeeder.php
│     ├─ RoleSeeder.php
│     └─ UserSeeder.php
├─ resources
│  ├─ css
│  │  ├─ app.css
│  │  ├─ backup.css
│  │  ├─ flash.css
│  │  └─ gsap.css
│  ├─ js
│  │  ├─ app.js
│  │  ├─ bootstrap.js
│  │  └─ flash.js
│  ├─ lang
│  │  ├─ bn
│  │  │  ├─ common.php
│  │  │  ├─ footer.php
│  │  │  ├─ home.php
│  │  │  ├─ navbar.php
│  │  │  ├─ newsletter.php
│  │  │  └─ products.php
│  │  └─ en
│  │     ├─ common.php
│  │     ├─ footer.php
│  │     ├─ home.php
│  │     ├─ navbar.php
│  │     ├─ newsletter.php
│  │     └─ products.php
│  └─ views
│     ├─ admin
│     │  ├─ ad-banners
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  └─ index.blade.php
│     │  ├─ analytics
│     │  │  ├─ customers.blade.php
│     │  │  ├─ index.blade.php
│     │  │  ├─ orders.blade.php
│     │  │  ├─ products.blade.php
│     │  │  ├─ reports
│     │  │  │  ├─ customers.blade.php
│     │  │  │  ├─ products.blade.php
│     │  │  │  └─ sales.blade.php
│     │  │  ├─ revenue.blade.php
│     │  │  └─ sales.blade.php
│     │  ├─ catalogs
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  └─ index.blade.php
│     │  ├─ categories
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ partials
│     │  │     └─ category-row.blade.php
│     │  ├─ dashboard
│     │  │  └─ index.blade.php
│     │  ├─ hero-slides
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  └─ index.blade.php
│     │  ├─ layouts
│     │  │  └─ app.blade.php
│     │  ├─ offers
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  └─ index.blade.php
│     │  ├─ orders
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ partials
│     │  │  ├─ breadcrumb.blade.php
│     │  │  ├─ footer.blade.php
│     │  │  ├─ sidebar.blade.php
│     │  │  └─ topbar.blade.php
│     │  ├─ products
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ sections
│     │  │  ├─ create.blade.php
│     │  │  ├─ edit.blade.php
│     │  │  └─ index.blade.php
│     │  ├─ settings
│     │  │  ├─ email.blade.php
│     │  │  ├─ general.blade.php
│     │  │  ├─ index.blade.php
│     │  │  ├─ maintenance.blade.php
│     │  │  ├─ payment.blade.php
│     │  │  ├─ permissions
│     │  │  │  └─ index.blade.php
│     │  │  ├─ roles
│     │  │  │  ├─ create.blade.php
│     │  │  │  ├─ edit.blade.php
│     │  │  │  ├─ index.blade.php
│     │  │  │  └─ partials
│     │  │  │     └─ permission-group.blade.php
│     │  │  ├─ shipping.blade.php
│     │  │  ├─ store.blade.php
│     │  │  └─ tax.blade.php
│     │  └─ users
│     │     ├─ create.blade.php
│     │     ├─ index.blade.php
│     │     └─ profile.blade.php
│     ├─ auth
│     │  ├─ confirm-password.blade.php
│     │  ├─ forgot-password.blade.php
│     │  ├─ login.blade.php
│     │  ├─ register.blade.php
│     │  ├─ reset-password.blade.php
│     │  └─ verify-email.blade.php
│     ├─ components
│     │  ├─ ads-banner.blade.php
│     │  ├─ category-slider.blade.php
│     │  ├─ danger-button.blade.php
│     │  ├─ flash-container.blade.php
│     │  ├─ guest-layout.blade.php
│     │  ├─ input-error.blade.php
│     │  ├─ input-label.blade.php
│     │  ├─ modal.blade.php
│     │  ├─ offer-product-card.blade.php
│     │  ├─ offer-products.blade.php
│     │  ├─ offer-section.blade.php
│     │  ├─ primary-button.blade.php
│     │  ├─ product-cards
│     │  │  ├─ minimal.blade.php
│     │  │  └─ modern.blade.php
│     │  ├─ product-slider.blade.php
│     │  ├─ products.blade.php
│     │  ├─ secondary-button.blade.php
│     │  ├─ server-flash.blade.php
│     │  └─ text-input.blade.php
│     ├─ customer
│     │  ├─ dashboard.blade.php
│     │  ├─ order.blade.php
│     │  └─ profile.blade.php
│     ├─ errors
│     │  ├─ 404.blade.php
│     │  └─ 500.blade.php
│     ├─ frontend
│     │  ├─ cart
│     │  │  └─ index.blade.php
│     │  ├─ categories
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ checkout
│     │  │  ├─ failed.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ success.blade.php
│     │  ├─ home.blade.php
│     │  ├─ layouts
│     │  │  ├─ app.blade.php
│     │  │  └─ guest.blade.php
│     │  ├─ orders
│     │  │  ├─ index.blade.php
│     │  │  ├─ show.blade.php
│     │  │  └─ track.blade.php
│     │  ├─ pages
│     │  │  ├─ about.blade.php
│     │  │  ├─ catalogs.blade.php
│     │  │  ├─ contact.blade.php
│     │  │  ├─ faq.blade.php
│     │  │  ├─ privacy.blade.php
│     │  │  ├─ returns.blade.php
│     │  │  ├─ shipping.blade.php
│     │  │  ├─ support.blade.php
│     │  │  └─ terms.blade.php
│     │  ├─ partials
│     │  │  ├─ ads-banner.blade.php
│     │  │  ├─ footer.blade.php
│     │  │  ├─ hero.blade.php
│     │  │  ├─ navbar.blade.php
│     │  │  ├─ newsletter.blade.php
│     │  │  ├─ product-card.blade.php
│     │  │  ├─ search-sidebar.blade.php
│     │  │  ├─ smart-section.blade.php
│     │  │  └─ user-stories.blade.php
│     │  ├─ products
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  └─ search
│     │     └─ results.blade.php
│     └─ layouts
│        └─ app.blade.php
├─ routes
│  ├─ admin.php
│  ├─ auth.php
│  ├─ console.php
│  └─ web.php
├─ tailwind.config.js
└─ vite.config.js

```
