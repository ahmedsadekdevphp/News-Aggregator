# News Aggregator
  The News Aggregator Backend is a Larevl-based application that fetch News from different sources and provides users the ability to view news feeds, search for news with customizable filters, and set personalized news feed preferences. The app also includes features for user registration and login, allowing users to manage their preferences and stay updated with the latest news from diffrent sources.

## Software Design 
 The challenge of fetching news from multiple sources, each with different endpoints and response structures, can be approached in several ways. In this solution, I’ve implemented a configuration-driven approach using the newsproviders.php file.

This configuration allows you to easily add new news provider endpoints and map their responses to database fields without needing to modify any core code. Simply update the configuration with new provider details, including the API URL, parameters, and response mappings.

Here’s an example configuration for a news provider:

```bash

 'providers' => [
        'nytimes' => [
            'url' => 'https://api.nytimes.com/svc/search/v2/articlesearch.json',
            'date_key' => 'begin_date',
            'request_body' => [
                'begin_date' => '',
                'api-key' => '',
            ],
            'response_path' => 'response.docs',
            'fields_map' => [
                'title' => 'headline.main',
                'url' => 'web_url',
                'published_at' => 'pub_date',
                'category' => 'section_name',
                'type' => 'type_of_material',
                'source_id' => '_id',
                'author' => 'byline.original'
            ],

        ]
    ],
```
## 🚀 Getting Started  

### Requirements  
- **PHP**: 8.1 or higher  
- **Composer**: Latest version  
- **Database**: MySQL  


## Installation  

1. **Clone the Repository**  
   ```bash  
   git clone [repository-url]  
   cd news
   ```  

2. **Install Dependencies**  
   ```bash  
   composer install  
   ```  

3. **Environment Setup**  
   ```bash  
   cp .env.example .env  
   php artisan key:generate  
   ```  

4. **Configure Environment Variables**  
   Edit the `.env` file with your database and other configuration settings:  
   ```  
   DB_CONNECTION=mysql  
   DB_HOST=127.0.0.1  
   DB_PORT=3306  
   DB_DATABASE=your_database  
   DB_USERNAME=your_username  
   DB_PASSWORD=your_password  
   ```  

5. **Run Migrations**  
   ```bash  
   php artisan migrate  
   ```  



6. **Clear Application Cache**  
   ```bash  
   php artisan cache:clear  
   php artisan route:clear  
   php artisan config:clear  
   php artisan view:clear  
   ```

7. **run laravel Scedule** 
     ```bash  
    php artisan schedule:run 
     ```
8. **Ftech News Command** 
     ```bash  
    php artisan news:fetch 
     ```
