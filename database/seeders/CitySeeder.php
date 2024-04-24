<?php

namespace Database\Seeders;

use App\Models\Admin\Settings\Location\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $city = [
            [
                'id' => 1,
                'name' => 'DELHI',
                'state_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'NEW DELHI',
                'state_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'NOIDA',
                'state_id' => 1,
            ],
            [
                'id' => 4,
                'name' => 'WEST DELHI',
                'state_id' => 1,
            ],
            [
                'id' => 5,
                'name' => 'ASHOK VIHAR',
                'state_id' => 1,
            ],
            [
                'id' => 6,
                'name' => 'NANGLI POONA',
                'state_id' => 1,
            ],
            [
                'id' => 7,
                'name' => 'ENCALVE PART 2, JAMIA NAGAR, South',
                'state_id' => 1,
            ],
            [
                'id' => 8,
                'name' => 'MATHURA',
                'state_id' => 1,
            ],
            [
                'id' => 9,
                'name' => 'SHAHBAD DAULATPUR',
                'state_id' => 1,
            ],
            [
                'id' => 10,
                'name' => 'MUZAFFAR NAGAR',
                'state_id' => 2,
            ],
            [
                'id' => 11,
                'name' => 'MEERUT CITY',
                'state_id' => 2,
            ],
            [
                'id' => 12,
                'name' => 'PANCHSHEEL NAGAR',
                'state_id' => 2,
            ],
            [
                'id' => 13,
                'name' => 'RISHIKESH',
                'state_id' => 2,
            ],
            [
                'id' => 14,
                'name' => 'GHAZIABAD',
                'state_id' => 2,
            ],
            [
                'id' => 15,
                'name' => 'ALIGARH',
                'state_id' => 2,
            ],
            [
                'id' => 16,
                'name' => 'MEERUT',
                'state_id' => 2,
            ],
            [
                'id' => 17,
                'name' => 'SAHARANPUR',
                'state_id' => 2,
            ],
            [
                'id' => 18,
                'name' => 'RUDRAPUR',
                'state_id' => 2,
            ],
            [
                'id' => 19,
                'name' => 'AGRA',
                'state_id' => 2,
            ],
            [
                'id' => 20,
                'name' => 'GAZIABAD',
                'state_id' => 2,
            ],
            [
                'id' => 21,
                'name' => 'LUCKNOW',
                'state_id' => 2,
            ],
            [
                'id' => 22,
                'name' => 'VARANASI',
                'state_id' => 2,
            ],
            [
                'id' => 23,
                'name' => 'KANPUR',
                'state_id' => 2,
            ],
            [
                'id' => 24,
                'name' => 'Gonda',
                'state_id' => 2,
            ],
            [
                'id' => 25,
                'name' => 'ORAI',
                'state_id' => 2,
            ],
            [
                'id' => 26,
                'name' => 'JHANSI',
                'state_id' => 2,
            ],
            [
                'id' => 27,
                'name' => 'Sitapur',
                'state_id' => 2,
            ],
            [
                'id' => 28,
                'name' => 'REWARI',
                'state_id' => 3,
            ],
            [
                'id' => 29,
                'name' => 'HISAR',
                'state_id' => 3,
            ],
            [
                'id' => 30,
                'name' => 'PALWAL',
                'state_id' => 3,
            ],
            [
                'id' => 31,
                'name' => 'ROHTAK',
                'state_id' => 3,
            ],
            [
                'id' => 32,
                'name' => 'JIND',
                'state_id' => 3,
            ],
            [
                'id' => 33,
                'name' => 'Sirsa',
                'state_id' => 3,
            ],
            [
                'id' => 34,
                'name' => 'Jhajjar',
                'state_id' => 3,
            ],
            [
                'id' => 35,
                'name' => 'LADWA Kurukshetra',
                'state_id' => 3,
            ],
            [
                'id' => 36,
                'name' => 'Gurgaon',
                'state_id' => 3,
            ],
            [
                'id' => 37,
                'name' => 'Bahadurgarh',
                'state_id' => 3,
            ],
            [
                'id' => 38,
                'name' => 'SONIPAT',
                'state_id' => 3,
            ],
            [
                'id' => 39,
                'name' => 'FIROZPUR',
                'state_id' => 4,
            ],
            [
                'id' => 40,
                'name' => 'AMRITSAR',
                'state_id' => 4,
            ],
            [
                'id' => 41,
                'name' => 'JALANDHAR',
                'state_id' => 4,
            ],
            [
                'id' => 42,
                'name' => 'LUDHIANA',
                'state_id' => 4,
            ],
            [
                'id' => 43,
                'name' => 'DHANGU ROAD, PATHANKOT',
                'state_id' => 4,
            ],
            [
                'id' => 44,
                'name' => 'KATHUA',
                'state_id' => 4,
            ],
            [
                'id' => 45,
                'name' => 'PATIALA',
                'state_id' => 4,
            ],
            [
                'id' => 46,
                'name' => 'BATHINDA',
                'state_id' => 4,
            ],
            [
                'id' => 47,
                'name' => 'JAIPUR',
                'state_id' => 5,
            ],
            [
                'id' => 48,
                'name' => 'KOTA',
                'state_id' => 5,
            ],
            [
                'id' => 49,
                'name' => 'KOLKATA',
                'state_id' => 6,
            ],
            [
                'id' => 50,
                'name' => 'HOWRAH',
                'state_id' => 6,
            ],
            [
                'id' => 51,
                'name' => 'NORTH 24 PARGANAS',
                'state_id' => 6,
            ],
            [
                'id' => 52,
                'name' => 'PORT BLAIR',
                'state_id' => 6,
            ],
            [
                'id' => 53,
                'name' => 'South 24 Parganas',
                'state_id' => 6,
            ],
            [
                'id' => 54,
                'name' => 'CUTTACK',
                'state_id' => 7,
            ],
            [
                'id' => 55,
                'name' => 'BHUBANESWAR',
                'state_id' => 7,
            ],
            [
                'id' => 56,
                'name' => 'BHUBNESHWAR',
                'state_id' => 7,
            ],
            [
                'id' => 57,
                'name' => 'KHORDHA',
                'state_id' => 7,
            ],
            [
                'id' => 58,
                'name' => 'BALASORE',
                'state_id' => 7,
            ],
            [
                'id' => 59,
                'name' => 'DANPUR',
                'state_id' => 7,
            ],
            [
                'id' => 60,
                'name' => 'PATNA',
                'state_id' => 8,
            ],
            [
                'id' => 61,
                'name' => 'JAMSHEDPUR',
                'state_id' => 9,
            ],
            [
                'id' => 62,
                'name' => 'PURNEA',
                'state_id' => 9,
            ],
            [
                'id' => 63,
                'name' => 'ROHTAS',
                'state_id' => 9,
            ],
            [
                'id' => 64,
                'name' => 'BHAGALPUR',
                'state_id' => 9,
            ],
            [
                'id' => 65,
                'name' => 'Samastipur',
                'state_id' => 9,
            ],
            [
                'id' => 66,
                'name' => 'ramnagari more',
                'state_id' => 9,
            ],
            [
                'id' => 67,
                'name' => ' MOTIHARI',
                'state_id' => 9,
            ],
            [
                'id' => 68,
                'name' => 'MOTIHARI',
                'state_id' => 9,
            ],
            [
                'id' => 69,
                'name' => 'Siwan',
                'state_id' => 9,
            ],
            [
                'id' => 70,
                'name' => 'RANCHI',
                'state_id' => 9,
            ],
            [
                'id' => 71,
                'name' => 'DHANBAD',
                'state_id' => 9,
            ],
            [
                'id' => 72,
                'name' => 'Purulia',
                'state_id' => 9,
            ],
            [
                'id' => 73,
                'name' => 'THANE',
                'state_id' => 10,
            ],
            [
                'id' => 74,
                'name' => 'MUMBAI',
                'state_id' => 10,
            ],
            [
                'id' => 75,
                'name' => 'DOMBILI(E)',
                'state_id' => 10,
            ],
            [
                'id' => 76,
                'name' => 'GOREGAON(W)',
                'state_id' => 10,
            ],
            [
                'id' => 77,
                'name' => 'NAVI MUMBAI',
                'state_id' => 10,
            ],
            [
                'id' => 78,
                'name' => 'KANDIVALI WEST',
                'state_id' => 10,
            ],
            [
                'id' => 79,
                'name' => 'Raigad',
                'state_id' => 10,
            ],
            [
                'id' => 80,
                'name' => 'DAHISAR EAST',
                'state_id' => 10,
            ],
            [
                'id' => 81,
                'name' => 'BORIVALI',
                'state_id' => 10,
            ],
            [
                'id' => 82,
                'name' => 'BYCULLA',
                'state_id' => 10,
            ],
            [
                'id' => 83,
                'name' => 'Matunga',
                'state_id' => 10,
            ],
            [
                'id' => 84,
                'name' => 'MUMBAI SUBURBAN',
                'state_id' => 10,
            ],
            [
                'id' => 85,
                'name' => 'ICHALKARANJI',
                'state_id' => 10,
            ],
            [
                'id' => 86,
                'name' => 'KOLHAPUR',
                'state_id' => 10,
            ],
            [
                'id' => 87,
                'name' => 'NASHIK',
                'state_id' => 10,
            ],
            [
                'id' => 88,
                'name' => 'Pune',
                'state_id' => 10,
            ],
            [
                'id' => 89,
                'name' => 'Nagpur',
                'state_id' => 10,
            ],
            [
                'id' => 90,
                'name' => 'AMRAVATI',
                'state_id' => 11,
            ],
            [
                'id' => 91,
                'name' => 'WARDHA',
                'state_id' => 11,
            ],
            [
                'id' => 92,
                'name' => 'BHAV NAGAR',
                'state_id' => 11,
            ],
            [
                'id' => 93,
                'name' => 'RAJKOT',
                'state_id' => 11,
            ],
            [
                'id' => 94,
                'name' => 'HIMMAT NAGAR',
                'state_id' => 11,
            ],
            [
                'id' => 95,
                'name' => 'AHMEDABAD',
                'state_id' => 11,
            ],
            [
                'id' => 96,
                'name' => 'PATAN',
                'state_id' => 11,
            ],
            [
                'id' => 97,
                'name' => 'SURAT',
                'state_id' => 11,
            ],
            [
                'id' => 98,
                'name' => 'INDORE',
                'state_id' => 12,
            ],
            [
                'id' => 99,
                'name' => 'BHAVNAGAR',
                'state_id' => 12,
            ],
            [
                'id' => 100,
                'name' => 'Bhopal',
                'state_id' => 12,
            ],
            [
                'id' => 101,
                'name' => 'MANDSAUR',
                'state_id' => 12,
            ],
            [
                'id' => 102,
                'name' => 'SHAHDOL',
                'state_id' => 12,
            ],
            [
                'id' => 103,
                'name' => 'SATNA',
                'state_id' => 12,
            ],
            [
                'id' => 104,
                'name' => 'JABALPUR',
                'state_id' => 12,
            ],
            [
                'id' => 105,
                'name' => 'GWALIOR',
                'state_id' => 12,
            ],
            [
                'id' => 106,
                'name' => 'PANDARI',
                'state_id' => 13,
            ],
            [
                'id' => 107,
                'name' => 'RAIPUR',
                'state_id' => 13,
            ],
            [
                'id' => 108,
                'name' => 'CHENNAI',
                'state_id' => 14,
            ],
            [
                'id' => 109,
                'name' => 'KARUR',
                'state_id' => 14,
            ],
            [
                'id' => 110,
                'name' => 'PUDUCHERRY',
                'state_id' => 14,
            ],
            [
                'id' => 111,
                'name' => 'Kanchipuram',
                'state_id' => 14,
            ],
            [
                'id' => 112,
                'name' => 'Thiruvallur',
                'state_id' => 14,
            ],
            [
                'id' => 113,
                'name' => 'MADURAI',
                'state_id' => 14,
            ],
            [
                'id' => 114,
                'name' => 'COIMBATORE',
                'state_id' => 14,
            ],
            [
                'id' => 115,
                'name' => 'SALEM',
                'state_id' => 14,
            ],
            [
                'id' => 116,
                'name' => 'TIRUNELVELI',
                'state_id' => 14,
            ],
            [
                'id' => 117,
                'name' => 'THANJAVUR',
                'state_id' => 14,
            ],
            [
                'id' => 118,
                'name' => 'ERODE',
                'state_id' => 14,
            ],
            [
                'id' => 119,
                'name' => 'TIRUPUR',
                'state_id' => 14,
            ],
            [
                'id' => 120,
                'name' => 'TIRUPPUR',
                'state_id' => 14,
            ],
            [
                'id' => 121,
                'name' => 'Namakkal',
                'state_id' => 14,
            ],
            [
                'id' => 122,
                'name' => 'Tiruchirappalli',
                'state_id' => 14,
            ],
            [
                'id' => 123,
                'name' => 'Pathanamthitta',
                'state_id' => 15,
            ],
            [
                'id' => 124,
                'name' => 'TRIVANDRUM',
                'state_id' => 15,
            ],
            [
                'id' => 125,
                'name' => 'KOZHIKKODE',
                'state_id' => 15,
            ],
            [
                'id' => 126,
                'name' => 'TRICHAMBARAM',
                'state_id' => 15,
            ],
            [
                'id' => 127,
                'name' => 'Changanacerry',
                'state_id' => 15,
            ],
            [
                'id' => 128,
                'name' => 'KANNUR',
                'state_id' => 15,
            ],
            [
                'id' => 129,
                'name' => 'KOTTAYAM',
                'state_id' => 15,
            ],
            [
                'id' => 130,
                'name' => 'THRISSUR',
                'state_id' => 15,
            ],
            [
                'id' => 131,
                'name' => 'Kerala',
                'state_id' => 15,
            ],
            [
                'id' => 132,
                'name' => 'KOZHIKODE',
                'state_id' => 15,
            ],
            [
                'id' => 133,
                'name' => 'ERNAKULAM',
                'state_id' => 15,
            ],
            [
                'id' => 134,
                'name' => 'TALIPARAMBA',
                'state_id' => 15,
            ],
            [
                'id' => 135,
                'name' => 'Kollam',
                'state_id' => 15,
            ],
            [
                'id' => 136,
                'name' => 'PERINADU',
                'state_id' => 15,
            ],
            [
                'id' => 137,
                'name' => 'KAZHAKUTTOM',
                'state_id' => 15,
            ],
            [
                'id' => 138,
                'name' => 'MALAPPURAM',
                'state_id' => 15,
            ],
            [
                'id' => 139,
                'name' => 'SECUNDRABAD',
                'state_id' => 16,
            ],
            [
                'id' => 140,
                'name' => 'KODAD',
                'state_id' => 16,
            ],
            [
                'id' => 141,
                'name' => 'ANANTAPUR',
                'state_id' => 16,
            ],
            [
                'id' => 142,
                'name' => 'HYDERABAD',
                'state_id' => 16,
            ],
            [
                'id' => 143,
                'name' => 'KURNOOL',
                'state_id' => 16,
            ],
            [
                'id' => 144,
                'name' => 'KHAMMAM',
                'state_id' => 16,
            ],
            [
                'id' => 145,
                'name' => 'NIZAMABAD',
                'state_id' => 16,
            ],
            [
                'id' => 146,
                'name' => 'GUNTUR',
                'state_id' => 16,
            ],
            [
                'id' => 147,
                'name' => 'MAHABUBNAGAR',
                'state_id' => 16,
            ],
            [
                'id' => 148,
                'name' => 'KOTHAGUDEM',
                'state_id' => 16,
            ],
            [
                'id' => 149,
                'name' => 'Nizambad',
                'state_id' => 16,
            ],
            [
                'id' => 150,
                'name' => 'warangal',
                'state_id' => 16,
            ],
            [
                'id' => 151,
                'name' => 'Proddatoor',
                'state_id' => 16,
            ],
            [
                'id' => 152,
                'name' => 'Chandanagar',
                'state_id' => 16,
            ],
            [
                'id' => 153,
                'name' => 'Kadapa',
                'state_id' => 16,
            ],
            [
                'id' => 154,
                'name' => 'Tirupati',
                'state_id' => 17,
            ],
            [
                'id' => 155,
                'name' => 'Visakhapatnam',
                'state_id' => 17,
            ],
            [
                'id' => 156,
                'name' => 'VIJAYAWADA',
                'state_id' => 17,
            ],
            [
                'id' => 157,
                'name' => 'RAJAHMUNDRY',
                'state_id' => 17,
            ],
            [
                'id' => 158,
                'name' => 'MANDAPETA',
                'state_id' => 17,
            ],
            [
                'id' => 159,
                'name' => 'Govenorpet',
                'state_id' => 17,
            ],
            [
                'id' => 160,
                'name' => 'NARSAPURAM',
                'state_id' => 17,
            ],
            [
                'id' => 161,
                'name' => 'NELLORE',
                'state_id' => 17,
            ],
            [
                'id' => 162,
                'name' => 'PALAKOLLU',
                'state_id' => 17,
            ],
            [
                'id' => 163,
                'name' => 'TANUKU',
                'state_id' => 17,
            ],
            [
                'id' => 164,
                'name' => 'ONGOLE',
                'state_id' => 17,
            ],
            [
                'id' => 165,
                'name' => 'AMALAPURAM',
                'state_id' => 17,
            ],
            [
                'id' => 166,
                'name' => 'BHIMAVARAM',
                'state_id' => 17,
            ],
            [
                'id' => 167,
                'name' => 'NARSAPUR',
                'state_id' => 17,
            ],
            [
                'id' => 168,
                'name' => 'KRISHNA',
                'state_id' => 17,
            ],
            [
                'id' => 169,
                'name' => 'RAJAMAHENDRAVARAM',
                'state_id' => 17,
            ],
            [
                'id' => 170,
                'name' => 'Ravulapalem',
                'state_id' => 17,
            ],
            [
                'id' => 171,
                'name' => 'chinnaavutapalli',
                'state_id' => 17,
            ],
            [
                'id' => 172,
                'name' => 'Tadepalligudem',
                'state_id' => 17,
            ],
            [
                'id' => 173,
                'name' => 'Kakinada',
                'state_id' => 17,
            ],
            [
                'id' => 174,
                'name' => 'CHILAKALURIPET',
                'state_id' => 17,
            ],
            [
                'id' => 175,
                'name' => 'West Godavari',
                'state_id' => 17,
            ],
            [
                'id' => 176,
                'name' => 'ELURU',
                'state_id' => 17,
            ],
            [
                'id' => 177,
                'name' => 'GOVERNER PET',
                'state_id' => 17,
            ],
            [
                'id' => 178,
                'name' => 'BELLARY',
                'state_id' => 18,
            ],
            [
                'id' => 179,
                'name' => 'BENGALURU',
                'state_id' => 18,
            ],
            [
                'id' => 180,
                'name' => 'MANGALURU',
                'state_id' => 18,
            ],
            [
                'id' => 181,
                'name' => 'KARKALA',
                'state_id' => 18,
            ],
            [
                'id' => 182,
                'name' => 'HUBBALLI',
                'state_id' => 18,
            ],
            [
                'id' => 183,
                'name' => 'Doddabanaswad',
                'state_id' => 18,
            ],

            [
                'id' => 184,
                'name' => 'Fatehabad',
                'state_id' => 3,
            ],
            [
                'id' => 185,
                'name' => 'Hansi',
                'state_id' => 3,
            ],
            [
                'id' => 186,
                'name' => 'Koraput',
                'state_id' => 7,
            ],
            [
                'id' => 187,
                'name' => 'Jatani',
                'state_id' => 7,
            ],
            [
                'id' => 188,
                'name' => 'Purnia',
                'state_id' => 8,
            ],
            [
                'id' => 189,
                'name' => 'Daltonganj',
                'state_id' => 9,
            ],
            [
                'id' => 190,
                'name' => 'BOTAD',
                'state_id' => 11,
            ],
            [
                'id' => 191,
                'name' => 'Mehsana',
                'state_id' => 11,
            ],
            [
                'id' => 192,
                'name' => 'Razole',
                'state_id' => 17,
            ],
            [
                'id' => 193,
                'name' => 'Ichchapuram',
                'state_id' => 17,
            ],
        ];
        foreach ($city as $row) {
            City::create($row);
        }
    }
}
