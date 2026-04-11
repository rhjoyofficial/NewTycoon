
```
Tycoon
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
│  │  ├─ FooterService.php
│  │  ├─ NavigationService.php
│  │  ├─ Offer
│  │  │  └─ OfferService.php
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
│     ├─ BrandSeeder.php
│     ├─ CartSeeder.php
│     ├─ CatalogSeeder.php
│     ├─ CategorySeeder.php
│     ├─ DatabaseSeeder.php
│     ├─ FooterSeeder.php
│     ├─ HeroSlideSeeder.php
│     ├─ OfferSeeder.php
│     ├─ OrderSeeder.php
│     ├─ PermissionSeeder.php
│     ├─ ProductSeeder.php
│     ├─ ReviewSeeder.php
│     ├─ RolePermissionSeeder.php
│     ├─ RoleSeeder.php
│     ├─ SectionSeeder.php
│     ├─ UserProfileSeeder.php
│     └─ UserSeeder.php
├─ needs.txt
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ postcss.config.js
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ images
│  │  ├─ 4659490.png
│  │  ├─ ads
│  │  │  ├─ addss.png
│  │  │  ├─ ads.jpg
│  │  │  ├─ ads15.png
│  │  │  ├─ ads2.png
│  │  │  ├─ ads3.png
│  │  │  ├─ adss.jpg
│  │  │  ├─ adsss.png
│  │  │  └─ Gemini_Generated_Image_ytnm84ytnm84ytnm.png
│  │  ├─ bk png.png
│  │  ├─ bk-logo.png
│  │  ├─ car.jpg
│  │  ├─ cat
│  │  │  ├─ ac.png
│  │  │  ├─ cookware.png
│  │  │  ├─ default.png
│  │  │  ├─ default2.png
│  │  │  ├─ electric-kettle.png
│  │  │  ├─ fan.png
│  │  │  ├─ gas-burner.png
│  │  │  ├─ led-tv.png
│  │  │  ├─ mixer-grinder.png
│  │  │  ├─ monitor.png
│  │  │  ├─ pressure-cooker.png
│  │  │  ├─ refrigerator.png
│  │  │  ├─ rice-cooker.png
│  │  │  └─ room-comporter.png
│  │  ├─ fav.png
│  │  ├─ footer-product.png
│  │  ├─ hero
│  │  │  ├─ demo-banner-no.jpg
│  │  │  ├─ demo-banner.jpg
│  │  │  ├─ demo-banner12.png
│  │  │  ├─ hero-background.mp4
│  │  │  ├─ slide1.jpg
│  │  │  ├─ slide2.jpg
│  │  │  ├─ slide3.jpg
│  │  │  └─ slide4.jpg
│  │  ├─ no-image.jpg
│  │  ├─ offers
│  │  │  ├─ bg.jpg
│  │  │  ├─ Gemini_Generated_Image_utd59lutd59lutd5.png
│  │  │  ├─ main-banner.jpeg
│  │  │  ├─ main-banner.jpg
│  │  │  ├─ main-banner.png
│  │  │  ├─ offers-bg.gif
│  │  │  └─ winter-bg.jpg
│  │  ├─ placeholder.jpg
│  │  ├─ products
│  │  │  ├─ 1.png
│  │  ├─ smartads
│  │  │  ├─ air-purifier.png
│  │  │  └─ tv.png
│  │  ├─ stories
│  │  │  ├─ bd-01.jpg
│  │  └─ wh-logo.png
│  ├─ index.php
│  ├─ js
│  │  ├─ button-lock.js
│  │  ├─ cart.js
│  │  ├─ gsap
│  │  │  ├─ gsap-featured-products.js
│  │  │  ├─ gsap-offer-products.js
│  │  │  └─ gsap-tilt-category-card.js
│  │  └─ wishlist.js
│  ├─ robots.txt
│  └─ videos
│     ├─ 2offers-bg.mp4
│     ├─ back-cover-video.mp4
│     ├─ hero-background.mp4
│     ├─ offers-bg.mp4
│     └─ stories
│        ├─ story.mp4
│        └─ storyOk.mp4
├─ README.md
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
│  │  │  ├─ home.php
│  │  │  ├─ navbar.php
│  │  │  ├─ newsletter.php
│  │  │  └─ products.php
│  │  └─ en
│  │     ├─ common.php
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
│     │  └─ settings
│     │     ├─ email.blade.php
│     │     ├─ general.blade.php
│     │     ├─ index.blade.php
│     │     ├─ maintenance.blade.php
│     │     ├─ payment.blade.php
│     │     ├─ permissions
│     │     │  └─ index.blade.php
│     │     ├─ roles
│     │     │  ├─ create.blade.php
│     │     │  ├─ edit.blade.php
│     │     │  ├─ index.blade.php
│     │     │  └─ partials
│     │     │     └─ permission-group.blade.php
│     │     ├─ shipping.blade.php
│     │     ├─ store.blade.php
│     │     └─ tax.blade.php
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
│     │  ├─ flash-container.blade.php
│     │  ├─ offer-product-card.blade.php
│     │  ├─ offer-products.blade.php
│     │  ├─ offer-section.blade.php
│     │  ├─ product-cards
│     │  │  ├─ minimal.blade.php
│     │  │  └─ modern.blade.php
│     │  ├─ product-slider.blade.php
│     │  ├─ products.blade.php
│     │  └─ server-flash.blade.php
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
│     ├─ profile
│     │  ├─ edit.blade.php
│     │  └─ partials
│     │     ├─ delete-user-form.blade.php
│     │     ├─ update-password-form.blade.php
│     │     └─ update-profile-information-form.blade.php
│     └─ test-flash.blade.php
├─ routes
│  ├─ admin.php
│  ├─ auth.php
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  └─ public
│  ├─ debugbar
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  ├─ testing
│  │  └─ views
│  └─ logs
├─ tailwind.config.js
├─ tests
│  ├─ Feature
│  │  ├─ Auth
│  │  │  ├─ AuthenticationTest.php
│  │  │  ├─ EmailVerificationTest.php
│  │  │  ├─ PasswordConfirmationTest.php
│  │  │  ├─ PasswordResetTest.php
│  │  │  ├─ PasswordUpdateTest.php
│  │  │  └─ RegistrationTest.php
│  │  ├─ ExampleTest.php
│  │  └─ ProfileTest.php
│  ├─ Pest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```