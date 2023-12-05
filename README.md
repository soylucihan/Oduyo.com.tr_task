/register
- Kullanıcı kaydının ardından yeni kullanıcıya hoş geldiniz e-postası gönderen sıraya alınmış bir iş oluşturulur.

/reset-password
- Parola sıfırlama istekleri için 5 dakikalık bir gecikmeyle yürütülen kuyruğa alınmış bir iş oluşturulur.

/queue-management
- Kuyruktaki işleri yönetmek için bir arayüz


Test için Mail ayarlarımı kullanabilirsiniz. 

Kurulum:
1. projeyi klonlayın.
2. database oluşturup .env dosyasında database bilgilerinizi düzenleyin.
3. "composer install"  komutu ile kurulumu yapın.
4. "php artisan migrate" komutu ile tabloları oluşturun.
5. "php artisan serve" komutu ile projeyi çalıştırın.
6. farklı bir terminalde "php artisan queue:work" komutu ile kuyruğu başlatın.


