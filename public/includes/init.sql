CREATE TABLE catalogue_admin (
    account_id INT(2) AUTO_INCREMENT PRIMARY KEY,
    users VARCHAR(16) NOT NULL,
    hashed_pass VARCHAR(72) NOT NULL
);

INSERT INTO catalogue_admin (users, hashed_pass)
VALUES ('instructor', '$2y$10$0bEQo3Y9hN0yAOkMrf2uL.xbGV96gX0O8zmuFXooAmp/hck2T6JRW'),
('hershey', '$2y$10$QoC3pxz0nPlW07pYwI/Efum2O10aIHdfWeEsqxfciJ4tVSfygwmXO');

CREATE TABLE fun_facts (
    fact_id INT AUTO_INCREMENT PRIMARY KEY,
    destination VARCHAR(50) NOT NULL,
    fact VARCHAR (255) NOT NULL
);

INSERT INTO fun_facts (destination, fact) VALUES
('London', 'London has over 170 museums, including the famous British Museum.'),
('Edinburgh', 'Edinburgh was the first city in the world to have its own fire brigade.'),
('Singapore', 'Singapore is one of only three city-states in the world.'),
('Yangon', 'The Shwedagon Pagoda is believed to be over 2,600 years old.'),
('Bangkok', "Bangkok's full ceremonial name has 168 letters and is the longest city name in the world."),
('Dubai', 'The Burj Khalifa in Dubai is the tallest building in the world at 828 meters.'),
('Doha', 'Doha will host the 2030 Asian Games.'),
('Male', "About 99% of the Maldives' territory is ocean."),
('Seoul', 'Seoul is home to five UNESCO World Heritage Sites.'),
('San Francisco', 'The Golden Gate Bridge is painted "International Orange" for visibility in the fog.'),
('New York', 'Times Square is named after The New York Times newspaper.'),
('Cape Town', 'Table Mountain is one of the New7Wonders of Nature.'),
('Salisbury', 'Stonehenge is estimated to be over 5,000 years old.'),
('Istanbul', 'Istanbul is the only city in the world that spans two continents.'),
('Tokyo', 'Tokyo has more Michelin-starred restaurants than any other city.'),
('Machu Picchu', 'Machu Picchu was unknown to the outside world until 1911.'),
('Bern', "Bern's name comes from the German word for bear."),
('Cappadocia', "Cappadocia's underground cities could once shelter thousands of people."),
('Queenstown', 'Queenstown is known as the "Adventure Capital of the World".'),
('Sydney', 'The Sydney Opera House roof design was inspired by orange slices.'),
('Kuala Lumpur', 'The Petronas Twin Towers in Kuala Lumpur were once the tallest buildings in the world and they are still the tallest twin towers today!'),
('Houston', "Houston is home to NASA's Johnson Space Center, where the iconic words 'Houston, we have a problem' originated during the Apollo 13 mission."),
('Los Angeles', 'Los Angeles is home to the world-famous Hollywood sign, which originally read "Hollywoodland" when it was erected in 1923 as a real estate advertisement.'),
('Hong Kong', 'Hong Kong has more skyscrapers than any other city in the world; over 9,000 high-rise buildings!'),
('Pumakkale', "Pamukkale's white terraces are made of travertine, a type of limestone deposited by hot springs; it looks like snow but feels like warm stone!");


CREATE TABLE travel_destinations (
    destination_id INT AUTO_INCREMENT PRIMARY KEY,             
    filename VARCHAR(255) NULL,
    image_source VARCHAR(255),                    
    destination_title VARCHAR(50) NOT NULL,        
    description VARCHAR(255) NOT NULL,              
    destination_category ENUM('City', 'Landmark', 'Nature', 'Cultural Site') NOT NULL,                       
    region ENUM('Africa', 'Asia', 'Europe', 'North America', 'South America', 'Oceania', 'Antarctica') NOT NULL,          
    popular_activity VARCHAR(255),                  
    visited BOOLEAN NOT NULL,        
    best_time_to_visit VARCHAR(50),          
    currency VARCHAR(50),                           
    language VARCHAR(50),                          
    season_type ENUM('Tropical', 'Four Seasons', 'Dry/Wet', 'Monsoon', 'Arid', 'Polar'),                           
    local_cuisine VARCHAR(255)                      
);

INSERT INTO travel_destinations (filename, image_source, destination_title, description, destination_category, region, popular_activity, visited, best_time_to_visit, currency, language, season_type, local_cuisine) 
VALUES
('', 'https://pixabay.com/photos/pagoda-schwedagon-yangon-stupas-4909992/', 'Yangon', "Yangon is Myanmar's largest city, blending colonial architecture, bustling markets, and sacred Buddhist sites.", 'Cultural Site',
'Asia', 'Cultural sightseeing', TRUE, 'November to February', 'Kyat (MMK)', 'Burmese', 'Monsoon', 'Mohinga, Shan Noodles'),

('', 'https://pixabay.com/photos/pamukkale-sintered-lime-terraces-14986/', 'Pamukkale', 'A natural site in Turkey famous for its thermal terraces and ancient ruins of Hierapolis.', 'Nature', 'Europe', 'Hot springs, historical ruins', FALSE, 'April to October', 'Turkish Lira (TRY)', 'Turkish', 'Four Seasons', 'Kofte, Pide')

('', 'https://pixabay.com/photos/australia-sydney-city-port-4338882/', 'Sydney', "Sydney is Australia's largest city, famous for its harbourfront Opera House and beautiful beaches.", 'City',
'Oceania', 'City tours', FALSE, 'September to November', 'Australian Dollar (AUD)', 'English', 'Four Seasons', 'Meat pies, Barramundi, Vegemite'),

('', 'https://pixabay.com/photos/omani-shop-shopping-nizwa-3242317/', 'Doha', 'Doha is the capital of Qatar, combining traditional Arabic culture with modern skyscrapers and museums.', 'City', 'Asia', 'Museum tours', TRUE, 'November to April', 'Qatari Riyal (QAR)', 'Arabic, English', 'Arid', 'Machboos, Harees'),

('', 'https://pixabay.com/photos/palace-royal-palace-gyeongbok-palace-5831869/', 'Seoul', "Seoul is South Korea's capital, a metropolis where modern skyscrapers meet Buddhist temples and palaces.", 'City', 'Asia', 'City tours', TRUE, 'March to May', 'Korean Won (KRW)', 'Korean', 'Four Seasons', 'Bibimbap, Kimchi'),

('', 'https://pixabay.com/photos/lake-mountains-hut-mountain-lake-1681485/', 'Bern', 'Bern is the capital of Switzerland, known for its preserved medieval city center and scenic alpine views.' , 'City', 'Europe', 'Alpine views, old town', FALSE, 'June to August', 'Swiss Franc (CHF)', 'German, French, Italian', 'Four Seasons', 'Cheese, Chocolate'),

('', 'https://pixabay.com/photos/lanterns-japan-tokyo-temple-shrine-1043416/', 'Tokyo', "Tokyo is Japan's bustling capital, a mix of ultramodern cityscape, traditional temples, and pop culture.", 'City', 'Asia', 'Sightseeing, temples', FALSE, 'March to May', 'Yen (JPY)', 'Japanese', 'Four Seasons', 'Sushi, Ramen'),

('', 'https://pixabay.com/photos/u-a-e-dubai-hotel-burj-al-arab-1154532/', 'Dubai', 'Dubai is a futuristic city in the UAE, renowned for luxury shopping, ultramodern architecture, and lively nightlife.', 'City', 'Asia', 'Luxury shopping, sightseeing', TRUE, 'November to March', 'UAE Dirham (AED)', 'Arabic, English', 'Arid', 'Shawarma, Harees'),

('', 'https://pixabay.com/photos/new-york-city-urban-hudson-river-3558337/', 'New York', 'New York City is a global metropolis, home to towering skyscrapers, Broadway theaters, and world-famous landmarks.', 'City', 'North America', 'City tours, museums', TRUE, 'April to June', 'US Dollar (USD)', 'English', 'Four Seasons', 'Pizza, Bagels'),

('', 'https://pixabay.com/photos/houston-big-city-usa-texas-1620802/', 'Houston', "A major U.S. city in Texas, known for NASA's Space Center, multicultural cuisine, and vibrant arts.", 'City', 'North America', 'Space tours, museums', TRUE, 'February to April', 'US Dollar (USD)', 'English, Spanish', 'Four Seasons', 'Barbecue, Tex-Mex'),

('', 'https://pixabay.com/photos/hongkong-scenery-nightlife-city-4382984/', 'Hong Kong', 'A vibrant city and special administrative region of China known for its skyline, harbor, and street food.', 'City', 'Asia', 'Skyline views, shopping', TRUE, 'October to December', 'Hong Kong Dollar (HKD)', 'Cantonese, English', 'Monsoon', 'Dim Sum, Roast Goose'),

('', 'https://pixabay.com/photos/stonehenge-monument-stones-947348/', 'Salisbury', 'Salisbury is a cathedral city in England, near the prehistoric monument of Stonehenge.', 'Landmark', 'Europe', 'Sightseeing', TRUE, 'May to September', 'Pound Sterling (GBP)', 'English', 'Four Seasons', 'British classics'),

('', 'https://pixabay.com/photos/mosque-s%C3%BCleymaniye-istanbul-turkey-4055410/', 'Istanbul', 'Istanbul is a transcontinental city in Turkey, rich in history and once the capital of the Byzantine and Ottoman empires.', 'City',
'Europe', 'Historical sites', TRUE, 'April to May', 'Turkish Lira (TRY)', 'Turkish', 'Four Seasons', 'Kebabs, Baklava'),

('', 'https://pixabay.com/photos/machupicchu-peru-i-ncas-1138641/', 'Machu Picchu', 'Machu Picchu is a historic Incan citadel set high in the Andes Mountains of Peru.', 'Landmark', 'South America', 'Inca trail, ruins', FALSE, 'May to September', 'Sol (PEN)', 'Spanish, Quechua', 'Dry/Wet', 'Ceviche, Lomo Saltado'),

('', 'https://www.pexels.com/photo/petronas-tower-kuala-lumpur-malaysia-22804/', 'Kuala Lumpur', 'The capital of Malaysia, known for its iconic Petronas Towers, street food, and cultural fusion.', 'City', 'Asia', 'City exploration, shopping', TRUE, 'May to July', 'Malaysian Ringgit (MYR)', 'Malay, English', 'Tropical', 'Nasi Lemak, Satay'),

('', 'https://pixabay.com/photos/hollywood-united-states-los-angeles-573444/', 'Los Angeles', "LA is a sprawling Southern California city known as the center of the nation's film and television industry.", 'City', 'North America', 'Beach visits, Hollywood tours', TRUE, 'March to May', 'US Dollar (USD)', 'English, Spanish', 'Four Seasons', 'Tacos, In-N-Out Burger'),

('', 'https://pixabay.com/photos/hobbiton-hobbit-shire-movie-nature-5284518/', 'Queenstown', 'Queenstown is a resort town in New Zealand known for adventure sports and stunning alpine scenery.', 'City', 'Oceania', 'Adventure tourism', FALSE, 'December to February', 'New Zealand Dollar (NZD)', 'English, Maori', 'Four Seasons', 'Pavlova, Lamb'),

('', 'https://pixabay.com/photos/hot-air-balloon-balloon-sky-7217175/', 'Cappadocia', 'Cappadocia is a region in Turkey famed for its unique rock formations and ancient cave dwellings.', 'Landmark', 'Europe', 'Hot air balloon rides', FALSE, 'April to June', 'Turkish Lira (TRY)', 'Turkish', 'Four Seasons', 'Meze, Gozleme'),

('', 'https://www.pexels.com/photo/houses-near-shore-surrounded-by-mountains-51809/', 'Cape Town', "Cape Town is a port city on South Africa's southwest coast, known for Table Mountain and rich history.", 'Nature', 'Africa', 'Hiking, History', TRUE, 'October to April', 'Rand (ZAR)', 'English, Afrikaans, Xhosa', 'Dry/Wet', 'Braai, Biltong'),

('', 'https://www.pexels.com/photo/assorted-beach-hutts-1287452/', 'Male', 'Male is the compact capital of the Maldives, surrounded by turquoise waters and known for its island lifestyle.', 'Nature', 'Asia', 'Beach relaxation', TRUE, 'November to April', 'Maldivian Rufiyaa (MVR)', 'Dhivehi', 'Tropical', 'Mas Huni, Garudhiya'),

('', 'https://www.pexels.com/photo/man-standing-beside-parked-trikes-2078248/', 'Bangkok', 'Bangkok is the dynamic capital of Thailand, known for ornate temples, street life, and vibrant markets.', 'City', 'Asia', 'Temple visits', TRUE, 'November to February', 'Thai Baht (THB)', 'Thai', 'Tropical', 'Pad Thai, Tom Yum Goong'),

('', 'https://www.pexels.com/photo/marina-bay-sands-singapore-777059/', 'Singapore', 'Singapore is a vibrant city-state in Southeast Asia, known for its cleanliness, innovation, and multicultural heritage.', 'City', 'Asia', 'Urban exploration', TRUE, 'February to April', 'Singapore Dollar (SGD)', 'English, Mandarin, Malay, Tamil', 'Tropical', 'Chili Crab, Hainanese Chicken Rice'),

('', 'https://www.pexels.com/photo/brown-chateau-631911/', 'Edinburgh', "Edinburgh is Scotland's hilly capital, famous for its historic and cultural attractions, including a medieval Old Town.", 'Nature', 'Europe', 'Castle tours', TRUE, 'June to August', 'Pound Sterling (GBP)', 'English, Scots', 'Four Seasons', 'Haggis, Shortbread'),

('', 'https://www.pexels.com/photo/london-cityscape-460672/', 'London', 'A historic and modern city, London is the capital of England known for its rich history, iconic landmarks, and diverse culture.', 'City', 'Europe', 'Sightseeing', TRUE, 'May to September', 'Pound Sterling (GBP)', 'English', 'Four Seasons', 'Fish and Chips, Roast Beef'),

('', 'https://pixabay.com/photos/golden-gate-bridge-san-francisco-4271360/', 'San Francisco', 'San Francisco is a cultural hub in California, known for its hilly landscape, tech scene, and iconic Golden Gate Bridge.', 'City', 'North America', 'Bridge walk, history tours', TRUE, 'September to November', 'US Dollar (USD)', 'English', 'Four Seasons', 'Sourdough Bread, Seafood');









 <!-- The username is: instructor -->
 <!-- The password is: Password2! -->