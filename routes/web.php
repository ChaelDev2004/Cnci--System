<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\admin\aboutController;
use App\Http\Controllers\admin\LeaderController;
//first Controller HAHA
use App\Http\Controllers\WelcomeController;

// admin Controler haha
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\ChurchLocationController;
use App\Http\Controllers\Admin\PastorController;
use App\Http\Controllers\Admin\MinisterController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\HomeSettingsController;
use App\Http\Controllers\Admin\EventsPageController;
use App\Http\Controllers\Admin\DashboardController;
// Main Page Route
// Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/', [WelcomeController::class, 'index']);
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
  ->name('admin.dashboard');

Route::get('/Home-page-index', [App\Http\Controllers\HomeController::class, 'index'])->name('content.dashboard.admin.index');
Route::get('/about', [App\Http\Controllers\aboutController::class, 'index'])->name('about');
Route::get('/Event', [App\Http\Controllers\eventsPageController::class, 'index'])->name('content.dashboard.events');
Route::get('/Find-Us', [App\Http\Controllers\findUsController::class, 'index'])->name('findus');
Route::resource('leaders', LeaderController::class);

Route::get('/pastor/{slug}', [App\Http\Controllers\Admin\PastorController::class, 'show'])->name('pastor.show');
//guest route
Route::get('Home-edit', [HomeSettingsController::class, 'edit'])
  ->name('content.dashboard.home.edit');
Route::put('Home-edit', [HomeSettingsController::class, 'update'])
  ->name('content.dashboard.home.update');

Route::prefix('content/dashboard/admin')
  ->name('content.dashboard.admin.')
  ->group(function () {

    Route::get('/home/slides/create', [SlideController::class, 'create'])
      ->name('home.slides.create');
    Route::get('/locations/create', [ChurchLocationController::class, 'create'])
      ->name('locations.create');
  });
Route::resource('slides', App\Http\Controllers\Admin\SlideController::class)->except('show');
Route::resource('locations', App\Http\Controllers\Admin\ChurchLocationController::class)->except('show');
//pastorss route

Route::get('/Pastor/index', [PastorController::class, 'index'])
  ->name('content.dashboard.pastors.index');

Route::get('/Pastor/create', [PastorController::class, 'create'])
  ->name('content.dashboard.pastors.create');


//ministers route
Route::get('/Ministers/Create', [MinisterController::class, 'create'])
  ->name('content.dashboard.ministers.create');

Route::get('/Ministers/Index', [MinisterController::class, 'index'])
  ->name('content.dashboard.ministers.index');

Route::get('/Ministers/Edit', [MinisterController::class, 'edit'])
  ->name('content.dashboard.ministers.edit');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
  Route::get('/about-page', [App\Http\Controllers\Admin\AboutPageController::class, 'edit'])->name('content.dashboard.about');

  // About Page
  Route::get('/about-page', [AboutPageController::class, 'edit'])
    ->name('about.edit');

  Route::put('/about-page', [AboutPageController::class, 'update'])
    ->name('about.update');



  Route::put('/about-page', [AboutPageController::class, 'update'])
    ->name('about.update');

  //events page

  // Display Events
  Route::get('/Events-page', [EventsPageController::class, 'index'])
    ->name('events.index');

  // Create Event Form
  Route::get('/Events-page/create', [EventsPageController::class, 'create'])
    ->name('events.create');

  // Save Event
  Route::post('/Events-page/store', [EventsPageController::class, 'store'])
    ->name('events.store');

  // Edit Event Form
  Route::get('/Events-page/{event}/edit', [EventsPageController::class, 'edit'])
    ->name('events.edit');

  // Update Event
  Route::put('/Events-page/{event}', [EventsPageController::class, 'update'])
    ->name('  events.update');

  // Delete Event
  Route::delete('/Events-page/{event}', [EventsPageController::class, 'destroy'])
    ->name('events.destroy');

  // Toggle Active
  Route::get('/Events-page/{event}/toggle', [EventsPageController::class, 'toggleActive'])
    ->name('events.toggle');

  // Reorder
  Route::post('/Events-page/reorder', [EventsPageController::class, 'reorder'])
    ->name('events.reorder');


  // Leadership CRUD
  // Leader List
  Route::get('/leaders', [LeaderController::class, 'index'])
    ->name('content.dashboard.about');

  // Add Leader Page
  Route::get('/leaders/create', [LeaderController::class, 'create'])
    ->name('leaders.create');

  // Save Leader
  Route::post('/leaders', [LeaderController::class, 'store'])
    ->name('leaders.store');

  // Edit Leader Page
  Route::get('/leaders/{leader}/edit', [LeaderController::class, 'edit'])
    ->name('leaders.edit');

  // Update Leader
  Route::put('/leaders/{leader}', [LeaderController::class, 'update'])
    ->name('leaders.update');

  // Delete Leader
  Route::delete('/leaders/{leader}', [LeaderController::class, 'destroy'])
    ->name('leaders.destroy');


  Route::resource('pastors', PastorController::class)
    ->except('show');


  Route::resource('ministers', MinisterController::class)
    ->except('show');


  //pastor route
  Route::get('/dashboard/pastors/create', [PastorController::class, 'create'])
    ->name('content.dashboard.pastors.create');

  Route::resource('pastors', App\Http\Controllers\Admin\PastorController::class)->except('show');
  Route::resource('ministers', App\Http\Controllers\Admin\MinisterController::class)->except('show');
});
//admin login to dashboard

Route::get('/login', [AuthController::class, 'showLogin'])
  ->name('login');

Route::post('/login', [AuthController::class, 'login'])
  ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
  ->name('logout');

//admin login route

Route::middleware('auth')->group(function () {
  Route::get('/admin/dashboard', [AdminController::class, 'index'])
    ->name('admin.dashboard');
});
// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
