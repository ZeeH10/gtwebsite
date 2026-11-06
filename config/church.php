<?php

// Site content in one place so the church team can update it without touching templates.
// Items marked "PLACEHOLDER" still need real details from the church leadership.

return [
    'name' => 'Glad Tidings Fellowship',
    'branch' => 'Bethel Centre',
    'tagline' => '“Go ye therefore…” We are going.',
    'tagline_ref' => 'Matthew 28:19',
    'vision' => 'Our vision is to be a Christ-centered, family-oriented church that equips members for service.',
    'welcome' => 'Welcome to the Glad Tidings Fellowship family, where ministry is expressed through genuine service. From your first visit, you’re not just a guest but a cherished part of our extended family.',

    'address' => '5 Hancock Street, North End, Gqeberha',
    'phones' => ['084 610 8870', '078 293 3649'],
    'whatsapp' => '27846108870',
    'email' => env('CHURCH_EMAIL'), // receives prayer requests; set in .env
    'facebook' => 'https://www.facebook.com/groups/gtfec',
    'youtube' => null, // PLACEHOLDER: add channel URL when the media team creates one

    'pastor' => [
        'name' => 'Pastor Gratitude Kudyachete',
        'title' => 'Senior Pastor, Bethel Centre',
        'image' => 'pastor-gratitude.jpg',
        // PLACEHOLDER bio: replace with the pastor's own words.
        'bio' => [
            'Pastor Gratitude Kudyachete leads the Glad Tidings Fellowship family at Bethel Centre in North End, Gqeberha.',
            'His heart is to see a Christ-centred, family-oriented church where every member is equipped for service and sent out with the glad tidings of Jesus Christ.',
        ],
    ],

    // PLACEHOLDER: our story, to be written with the church leadership.
    'story' => [
        'Glad Tidings Fellowship Bethel Centre is part of the wider Glad Tidings Fellowship family of churches, a movement built on the Great Commission of Matthew 28:19.',
        'From our home at 5 Hancock Street in North End, we gather every week to worship, pray and grow in the Word, and we scatter into homes across Gqeberha to do life together in our home groups.',
    ],
    'family_url' => 'https://www.gladtidings.co.zw/',

    // PLACEHOLDER: confirm wording with church leadership.
    'beliefs' => [
        ['title' => 'The Bible', 'text' => 'The Scriptures are the inspired Word of God and our guide for faith and life.'],
        ['title' => 'Salvation', 'text' => 'Salvation is by grace through faith in Jesus Christ, who died and rose again (John 3:16).'],
        ['title' => 'The Holy Spirit', 'text' => 'The Holy Spirit empowers believers to live holy lives and serve with gifts.'],
        ['title' => 'The Great Commission', 'text' => 'Every believer is called to go and make disciples of all nations (Matthew 28:19).'],
    ],

    'services' => [
        ['day' => 'Sunday', 'time' => '09:00 – 12:00', 'name' => 'Morning Service', 'icon' => 'sun'],
        ['day' => 'Tuesday', 'time' => '18:00', 'name' => 'Home Groups', 'icon' => 'home'],
        ['day' => 'Friday', 'time' => '18:00', 'name' => 'Prayer Meeting', 'icon' => 'flame'],
    ],

    'ministries' => [
        ['name' => 'Praise & Worship', 'image' => 'gt-choir.jpg', 'text' => 'Leading the church into God’s presence through song every Sunday and at special services.'],
        ['name' => 'Home Groups', 'image' => 'gt-homegroup.jpg', 'text' => 'Small groups meeting in homes across Gqeberha on Tuesdays for Bible study, prayer and friendship.'],
        ['name' => 'Youth & Campus Society', 'image' => 'gt-youth.jpg', 'text' => 'Young adults and students growing in faith together, on campus and in the city.'],
        ['name' => 'Children’s Church', 'image' => 'gt-children.jpg', 'text' => 'Sunday school where children learn the Word in a safe, joyful and caring space.'],
        ['name' => 'Prayer Ministry', 'image' => 'gt-prayer.jpg', 'text' => 'Standing in the gap for the church, our city and every request we receive.'],
        ['name' => 'Evangelism & Outreach', 'image' => 'gt-worship.jpg', 'text' => 'Taking the glad tidings into Gqeberha and beyond, in obedience to the Great Commission.'],
    ],

    // Events split into upcoming/past automatically by date. Entries without 'poster' are PLACEHOLDERS.
    'events' => [
        [
            'date' => '2026-10-31', 'end' => '2026-11-01', 'name' => 'October Conference 2026: Possessing the Remaining Land',
            'time' => '08:30', 'image' => 'conference-2026.webp', 'poster' => true,
            'text' => 'Joshua 13:1. Hosted by Pst G Kudyachete with guest speakers Pst W Dlamini and Pst P Mfenyana.',
        ],
        ['date' => '2026-11-29', 'name' => 'Thanksgiving Sunday', 'time' => '09:00', 'image' => 'gt-choir.jpg', 'text' => 'A morning of praise and testimony as we give thanks for God’s faithfulness this year.'],
        ['date' => '2026-12-11', 'name' => 'Night of Prayer', 'time' => '18:00', 'image' => 'gt-prayer.jpg', 'text' => 'An extended Friday prayer meeting for families, the church and our nation.'],
        ['date' => '2026-12-25', 'name' => 'Christmas Day Service', 'time' => '09:00', 'image' => 'gt-worship.jpg', 'text' => 'Celebrate the birth of our Saviour with the Bethel Centre family. Bring a friend!'],
    ],

    'giving' => [
        'purposes' => ['Tithes & Offerings', 'Pastor’s Appreciation', 'Funeral Contributions', 'Conference', 'Weddings'],
        // PLACEHOLDER bank details
        'bank' => '[Bank name]',
        'account_name' => 'Glad Tidings Fellowship Bethel Centre',
        'account_number' => '[Account number]',
        'branch_code' => '[Branch code]',
    ],
];
