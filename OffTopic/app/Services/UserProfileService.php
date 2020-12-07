<?php


namespace App\Services;

use App\UserProfile;
use Illuminate\Support\Facades\Validator;

class UserProfileService
{
    /**
     * @var array
     */
    private $countries;

    /**
     * @var array
     */
    private $days;

    /**
     * @var array
     */
    private $months;

    /**
     * @var array
     */
    private $years;

    /**
     * UserProfileService constructor.
     */
    public function __construct()
    {
        $this->setCountries();
        $this->setYears();
        $this->setMonths();
        $this->setDays();
    }

    /**
     *  Validate UserProfile fields
     *
     * @param $fields
     * @return array
     */
    public static function validateUserProfileFields($fields)
    {
        $validator = Validator::make($fields, UserProfile::$rules, UserProfile::$messages);

        if($validator->fails()) {
            return [
                'status' => -1,
                'errors' => $validator->errors()
            ];
        }

        return $response = [
            'status' => 1
        ];
    }

    /**
     *  set countries for selector html element in edit view
     */
    private function setCountries()
    {
        $this->countries = [
            '' => '-',
            "Afghanistan" => 'Afghanistan',
            "Åland Islands" =>'Åland Islands',
            "Albania" =>'Albania',
            'Algeria' =>'Algeria',
            "American Samoa"=>'American Samoa',
            "Andorra"=>'Andorra',
            "Angola"=>'Angola',
            "Anguilla"=>'Anguilla',
            "Antarctica"=>'Antarctica',
            "Antigua and Barbuda"=>'Antigua and Barbuda',
            "Argentina"=>'Argentina',
            "Armenia"=>'Armenia',
            "Aruba"=>'Aruba',
            "Australia"=>'Australia',
            "Austria"=>'Austria',
            "Azerbaijan"=>'Azerbaijan',
            "Bahamas"=>'Bahamas',
            "Bahrain"=>'Bahrain',
            "Bangladesh"=>'Bangladesh',
            "Barbados"=> 'Barbados',
            "Belarus" => 'Belarus',
            "Belgium" => 'Belgium',
            "Belize" => 'Belize',
            "Benin" => 'Benin',
            "Bermuda" => 'Bermuda',
            "Bhutan" => 'Bhutan',
            "Bolivia" => 'Bolivia',
            "Bosnia and Herzegovina" => 'Bosnia and Herzegovina',
            "Botswana" => 'Botswana',
            "Bouvet Island" => 'Bouvet Island',
            "Brazil" => 'Brazil',
            "British Indian Ocean Territory" => 'British Indian Ocean Territory',
            "Brunei Darussalam" => 'Brunei Darussalam',
            "Bulgaria" => 'Bulgaria',
            "Burkina Faso" => 'Burkina Faso',
            "Burundi" => 'Burundi',
            "Cambodia" => 'Cambodia',
            "Cameroon" => 'Cameroon',
            "Canada" => 'Canada',
            "Cape Verde" => 'Cape Verde',
            "Cayman Islands" => 'Cayman Islands',
            "Central African Republic" => 'Central African Republic',
            "Chad" => 'Chad',
            "Chile" => 'Chile',
            "China" => 'China',
            "Christmas Island" => 'Christmas Island',
            "Cocos (Keeling) Islands" => 'Cocos (Keeling) Islands',
            "Colombia" => 'Colombia',
            "Comoros" => 'Comoros',
            "Congo" => 'Congo',
            "Congo, The Democratic Republic of The" => 'Congo, The Democratic Republic of The',
            "Cook Islands" => 'Cook Islands',
            "Costa Rica" => 'Costa Rica',
            "Cote D'ivoire" => "Cote D'ivoire",
            "Croatia" => 'Croatia',
            "Cuba" => 'Cuba',
            "Cyprus" => 'Cyprus',
            "Czech Republic" => 'Czech Republic',
            "Denmark" => 'Denmark',
            "Djibouti" => 'Djibouti',
            "Dominica" => 'Dominica',
            "Dominican Republic" => 'Dominican Republic',
            "Ecuador" => 'Ecuador',
            "Egypt" => 'Egypt',
            "El Salvador" => 'El Salvador',
            "Equatorial Guinea" => 'Equatorial Guinea',
            "Eritrea" => 'Eritrea',
            "Estonia" => 'Estonia',
            "Ethiopia" => 'Ethiopia',
            "Falkland Islands (Malvinas)" => 'Falkland Islands (Malvinas)',
            "Faroe Islands" => 'Faroe Islands',
            "Fiji" => 'Fiji',
            "Finland" => 'Finland',
            "France" => 'France',
            "French Guiana" => 'French Guiana',
            "French Polynesia" => 'French Polynesia',
            "French Southern Territories" => 'French Southern Territories',
            "Gabon" => 'Gabon',
            "Gambia" => 'Gambia',
            "Georgia" => 'Georgia',
            "Germany" => 'Germany',
            "Ghana" => 'Ghana',
            "Gibraltar" => 'Gibraltar',
            "Greece" => 'Greece',
            "Greenland" => 'Greenland',
            "Grenada" => 'Grenada',
            "Guadeloupe" => 'Guadeloupe',
            "Guam" => 'Guam',
            "Guatemala" => 'Guatemala',
            "Guernsey" => 'Guernsey',
            "Guinea" => 'Guinea',
            "Guinea-bissau" => 'Guinea-bissau',
            "Guyana" => 'Guyana',
            "Haiti" => 'Haiti',
            "Heard Island and Mcdonald Islands" => 'Heard Island and Mcdonald Islands',
            "Holy See (Vatican City State)" => 'Holy See (Vatican City State)',
            "Honduras" => 'Honduras',
            "Hong Kong" => 'Hong Kong',
            "Hungary" => 'Hungary',
            "Iceland" =>'Iceland',
            "India" => 'India',
            "Indonesia" => 'Indonesia',
            "Iran, Islamic Republic of" => 'Iran, Islamic Republic of',
            "Iraq" => 'Iraq',
            "Ireland" => 'Ireland',
            "Isle of Man" => 'Isle of Man',
            "Israel" => 'Israel',
            "Italy" => 'Italy',
            "Jamaica" => 'Jamaica',
            "Japan" => 'Japan',
            "Jersey" => 'Jersey',
            "Jordan" => 'Jordan',
            "Kazakhstan" => 'Kazakhstan',
            "Kenya" => 'Kenya',
            "Kiribati" => 'Kiribati',
            "Korea, Democratic People's Republic of" => "Korea, Democratic People's Republic of",
            "Korea, Republic of" => 'Korea, Republic of',
            "Kuwait" => 'Kuwait',
            "Kyrgyzstan" => 'Kyrgyzstan',
            "Lao People's Democratic Republic" => "Lao People's Democratic Republic",
            "Latvia" => 'Latvia',
            "Lebanon" => 'Lebanon',
            "Lesotho" => 'Lesotho',
            "Liberia" => 'Liberia',
            "Libyan Arab Jamahiriya" => 'Libyan Arab Jamahiriya',
            "Liechtenstein" => 'Liechtenstein',
            "Lithuania" => 'Lithuania',
            "Luxembourg" => 'Luxembourg',
            "Macao" => 'Macao',
            "Republic of North Macedonia" => 'Republic of North Macedonia',
            "Madagascar" => 'Madagascar',
            "Malawi" => 'Malawi',
            "Malaysia" => 'Malaysia',
            "Maldives" => 'Maldives',
            "Mali" => 'Mali',
            "Malta" => 'Malta',
            "Marshall Islands" => 'Marshall Islands',
            "Martinique" => 'Martinique',
            "Mauritania" => 'Mauritania',
            "Mauritius" => 'Mauritius',
            "Mayotte" => 'Mayotte',
            "Mexico" => 'Mexico',
            "Micronesia, Federated States of" => 'Micronesia, Federated States of',
            "Moldova, Republic of" => 'Moldova, Republic of',
            "Monaco" => 'Monaco',
            "Mongolia" => 'Mongolia',
            "Montenegro" => 'Montenegro',
            "Montserrat" => 'Montserrat',
            "Morocco" => 'Morocco',
            "Mozambique" => 'Mozambique',
            "Myanmar" => 'Myanmar',
            "Namibia" => 'Namibia',
            "Nauru" => 'Nauru',
            "Nepal" => 'Nepal',
            "Netherlands" => 'Netherlands',
            "Netherlands Antilles" => 'Netherlands Antilles',
            "New Caledonia" => 'New Caledonia',
            "New Zealand" => 'New Zealand',
            "Nicaragua" => 'Nicaragua',
            "Niger" => 'Niger',
            "Nigeria" => 'Nigeria',
            "Niue" => 'Niue',
            "Norfolk Island" => 'Norfolk Island',
            "Northern Mariana Islands" => 'Northern Mariana Islands',
            "Norway" => 'Norway',
            "Oman" => 'Oman',
            "Pakistan" => 'Pakistan',
            "Palau" => 'Palau',
            "Palestinian Territory, Occupied" => 'Palestinian Territory, Occupied',
            "Panama" => 'Panama',
            "Papua New Guinea" => 'Papua New Guinea',
            "Paraguay" => 'Paraguay',
            "Peru" => 'Peru',
            "Philippines" => 'Philippines',
            "Pitcairn" => 'Pitcairn',
            "Poland" => 'Poland',
            "Portugal" => 'Portugal',
            "Puerto Rico" => 'Puerto Rico',
            "Qatar" => 'Qatar',
            "Reunion" => 'Reunion',
            "Romania" => 'Romania',
            "Russian Federation" => 'Russian Federation',
            "Rwanda" => 'Rwanda',
            "Saint Helena" => 'Saint Helena',
            "Saint Kitts and Nevis" => 'Saint Kitts and Nevis',
            "Saint Lucia" => 'Saint Lucia',
            "Saint Pierre and Miquelon" => 'Saint Pierre and Miquelon',
            "Saint Vincent and The Grenadines" => 'Saint Vincent and The Grenadines',
            "Samoa" => 'Samoa',
            "San Marino" => 'San Marino',
            "Sao Tome and Principe" => 'Sao Tome and Principe',
            "Saudi Arabia" => 'Saudi Arabia',
            "Senegal" => 'Senegal',
            "Serbia" => 'Serbia',
            "Seychelles" => 'Seychelles',
            "Sierra Leone" => 'Sierra Leone',
            "Singapore" => 'Singapore',
            "Slovakia" => 'Slovakia',
            "Slovenia" => 'Slovenia',
            "Solomon Islands" => 'Solomon Islands',
            "Somalia" => 'Somalia',
            "South Africa" => 'South Africa',
            "South Georgia and The South Sandwich Islands" => 'South Georgia and The South Sandwich Islands',
            "Spain" => 'Spain',
            "Sri Lanka" => 'Sri Lanka',
            "Sudan" => 'Sudan',
            "Suriname" => 'Suriname',
            "Svalbard and Jan Mayen" => 'Svalbard and Jan Mayen',
            "Swaziland" => 'Swaziland',
            "Sweden" => 'Sweden',
            "Switzerland" => 'Switzerland',
            "Syrian Arab Republic" => 'Syrian Arab Republic',
            "Taiwan, Province of China" => 'Taiwan, Province of China',
            "Tajikistan" => 'Tajikistan',
            "Tanzania, United Republic of" => 'Tanzania, United Republic of',
            "Thailand" => 'Thailand',
            "Timor-leste" => 'Timor-leste',
            "Togo" => 'Togo',
            "Tokelau" => 'Tokelau',
            "Tonga" => 'Tonga',
            "Trinidad and Tobago" => 'Trinidad and Tobago',
            "Tunisia" => 'Tunisia',
            "Turkey" => 'Turkey',
            "Turkmenistan" => 'Turkmenistan',
            "Turks and Caicos Islands" => 'Turks and Caicos Islands',
            "Tuvalu" => 'Tuvalu',
            "Uganda" => 'Uganda',
            "Ukraine" => 'Ukraine',
            "United Arab Emirates" => 'United Arab Emirates',
            "United Kingdom" => 'United Kingdom',
            "United States" => 'United States',
            "United States Minor Outlying Islands" => 'United States Minor Outlying Islands',
            "Uruguay" => 'Uruguay',
            "Uzbekistan" => 'Uzbekistan',
            "Vanuatu" => 'Vanuatu',
            "Venezuela" => 'Venezuela',
            "Viet Nam" => 'Viet Nam',
            "Virgin Islands, British" => 'Virgin Islands, British',
            "Virgin Islands, U.S." => 'Virgin Islands, U.S.',
            "Wallis and Futuna" => 'Wallis and Futuna',
            "Western Sahara" => 'Western Sahara',
            "Yemen" => 'Yemen',
            "Zambia" => 'Zambia',
            "Zimbabwe" => 'Zimbabwe',
        ];
    }

    /**
     *  set years for selector html element in edit view
     */
    private function setYears()
    {
        $this->years = [
            "" => '-',
            "2015" => '2015',
            "2014" => '2014',
            "2013" => '2013',
            "2012" => '2012',
            "2011" => '2011',
            "2010" => '2010',
            "2009" => '2009',
            "2008" => '2008',
            "2007" => '2007',
            "2006" => '2006',
            "2005" => '2005',
            "2004" => '2004',
            "2003" => '2003',
            "2002" => '2002',
            "2001" => '2001',
            "2000" => '2000',
            "1999" => '1999',
            "1998" => '1998',
            "1997" => '1997',
            "1996" => '1996',
            "1995" => '1995',
            "1994" => '1994',
            "1993" => '1993',
            "1992" => '1992',
            "1991" => '1991',
            "1990" => '1990',
            "1989" => '1989',
            "1988" => '1988',
            "1987" => '1987',
            "1986" => '1986',
            "1985" => '1985',
            "1984" => '1984',
            "1983" => '1983',
            "1982" => '1982',
            "1981" => '1981',
            "1980" => '1980',
            "1979" => '1979',
            "1978" => '1978',
            "1977" => '1977',
            "1976" => '1976',
            "1975" => '1975',
            "1974" => '1974',
            "1973" => '1973',
            "1972" => '1972',
            "1971" => '1971',
            "1970" => '1970',
            "1969" => '1969',
            "1968" => '1968',
            "1967" => '1967',
            "1966" => '1966',
            "1965" => '1965',
            "1964" => '1964',
            "1963" => '1963',
            "1962" => '1962',
            "1961" => '1961',
            "1960" => '1960',
            "1959" => '1959',
            "1958" => '1958',
            "1957" => '1957',
            "1956" => '1956',
            "1955" => '1955',
            "1954" => '1954',
            "1953" => '1953',
            "1952" => '1952',
            "1951" => '1951',
            "1950" => '1950',
            "1949" => '1949',
            "1948" => '1948',
            "1947" => '1947',
            "1946" => '1946',
            "1945" => '1945',
            "1944" => '1944',
            "1943" => '1943',
            "1942" => '1942',
            "1941" => '1941',
            "1940" => '1940',
            "1939" => '1939',
            "1938" => '1938',
            "1937" => '1937',
            "1936" => '1936',
            "1935" => '1935',
            "1934" => '1934',
            "1933" => '1933',
            "1932" => '1932',
            "1931" => '1931',
            "1930" => '1930',
        ];
    }

    /**
     *  set days for selector html element in edit view
     */
    private function setDays()
    {
        $this->days = [
            '' => '-',
            "01" => '01',
            "02" => '02',
            "03" => '03',
            "04" => '04',
            "05" => '05',
            "06" => '06',
            "07" => '07',
            "08" => '08',
            "09" => '09',
            "10" => '10',
            "11" => '11',
            "12" => '12',
            "13" => '13',
            "14" => '14',
            "15" => '15',
            "16" => '16',
            "17" => '17',
            "18" => '18',
            "19" => '19',
            "20" => '20',
            "21" => '21',
            "22" => '22',
            "23" => '23',
            "24" => '24',
            "25" => '25',
            "26" => '26',
            "27" => '27',
            "28" => '28',
            "29" => '29',
            "30" => '30',
            "31" => '31',
        ];
    }

    /**
     *  set months for selector html element in edit view
     */
    private function setMonths()
    {
        $this->months = [
            "" => '-',
            "01" => '01',
            "02" => '02',
            "03" => '03',
            "04" => '04',
            "05" => '05',
            "06" => '06',
            "07" => '07',
            "08" => '08',
            "09" => '09',
            "10" => '10',
            "11" => '11',
            "12" => '12',
        ];
    }

    /**
     * @return array
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * @return array
     */
    public function getMonths()
    {
        return $this->months;
    }

    /**
     * @return array
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @return array
     */
    public function getYears()
    {
        return $this->years;
    }
}
