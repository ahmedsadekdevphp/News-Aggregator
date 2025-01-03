
# `News Aggregator` 🚀  

## 🌟 **What is News Aggregator?**  

The **News Aggregator**  Backend is a Larevl-based application that fetch News from different sources and provides users the ability to view news feeds, search for news with customizable filters, and set personalized news feed preferences. The app also includes features for user registration and login, allowing users to manage their preferences and stay updated with the latest news from diffrent sources.  

Key features include:  
- **Authentication**: Secure login, token-based support, and automatic logout.  
- **Security**: Enhanced protection through Laravel sanctum and route-level middleware.  

---  

## 🚀 **Releases**  
<details>  
<summary>v1.0.0 (04/01/2025)</summary>
#### 🆕 **New Features**  
- **API Endpoints**:  
---

## Public Endpoints  

### **User Registration**  
- **Route:** `POST /register`  
- **Controller:** `RegisterController@store`  
- **Description:**  
  Register a new user.  
- **Middleware:** `throttle:10,1` (Limits requests to 10 per minute)  

### **User Login**  
- **Route:** `POST /login`  
- **Controller:** `AuthController@store`  
- **Description:**  
  Authenticate a user and return an access token.  
- **Middleware:** `throttle:10,1`  

---

## Protected Endpoints  
All routes below are protected by the `auth:api` middleware.

### **News Search and Feed**  
#### **Search Form Lookups**  
- **Route:** `GET /search/lookups`  
- **Controller:** `NewsController@searchFormData`  
- **Description:**  
  Fetch lookup data for the search form, such as categories .  

#### **Search News**  
- **Route:** `GET /search`  
- **Controller:** `NewsController@search`  
- **Description:**  
  Search for news articles using query parameters.  

#### **News Feed**  
- **Route:** `GET /news/feed`  
- **Controller:** `NewsController@newsFeed`  
- **Description:**  
  Retrieve a personalized news feed for the authenticated user.  

### **User Preferences**  
#### **Preferences Lookups**  
- **Route:** `GET /preferences/lookups`  
- **Controller:** `UserPreferenceController@getPreferencesLookups`  
- **Description:**  
  Fetch lookup data for preferences, such as available categories or sources.  

#### **View Preferences**  
- **Route:** `GET /user/preferences`  
- **Controller:** `UserPreferenceController@showPreferences`  
- **Description:**  
  View the current preferences for the authenticated user.  

#### **Save Preferences**  
- **Route:** `POST /user/preferences`  
- **Controller:** `UserPreferenceController@savePreferences`  
- **Description:**  
  Save or update the user's preferences (e.g., categories, sources).  

### **User Logout**  
- **Route:** `POST /logout`  
- **Controller:** `AuthController@logout`  
- **Description:**  
  Logout the user and invalidate their access token.  

---

## Features  

- **Throttling:** Public endpoints (`/register`, `/login`) are protected against abuse, allowing 10 requests per minute per user.  
- **Authentication:** Private routes use `auth:api` middleware for secure access.  
- **Preferences Management:** Manage user settings for personalized news experiences.  
- **News Feed and Search:** Access robust news feed and search functionality.  

---

#### ✨ **Enhancements**  
- **Security Features**:  
    - Middleware protection for sensitive routes.  
    - Request throttling to mitigate abuse.  
    - Integration with **sanctum** for API-level authentication.  

#### 🐛 **Bug Fixes**  
- Initial release. No known bugs reported.  

</details>  

---  

## 🔧 **Technical Specifications**  
### Framework & Requirements  
- PHP 8.1+  
- Laravel Framework 10.10  

### Key Dependencies  
- **PHPUnit** 11.2 (Testing)  

---
