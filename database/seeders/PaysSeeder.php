<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class PaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pays = [
            ['pays' => 'Afghanistan'], ['pays' => 'Afrique du Sud'], ['pays' => 'Albanie'],
            ['pays' => 'Algérie'], ['pays' => 'Allemagne'], ['pays' => 'Andorre'],
            ['pays' => 'Angola'], ['pays' => 'Antigua-et-Barbuda'], ['pays' => 'Arabie Saoudite'],
            ['pays' => 'Argentine'], ['pays' => 'Arménie'], ['pays' => 'Australie'],
            ['pays' => 'Autriche'], ['pays' => 'Azerbaïdjan'], ['pays' => 'Bahamas'],
            ['pays' => 'Bahreïn'], ['pays' => 'Bangladesh'], ['pays' => 'Barbade'],
            ['pays' => 'Belgique'], ['pays' => 'Belize'], ['pays' => 'Bénin'],
            ['pays' => 'Bhoutan'], ['pays' => 'Biélorussie'], ['pays' => 'Birmanie'],
            ['pays' => 'Bolivie'], ['pays' => 'Bosnie-Herzégovine'], ['pays' => 'Botswana'],
            ['pays' => 'Brésil'], ['pays' => 'Brunei'], ['pays' => 'Bulgarie'],
            ['pays' => 'Burkina Faso'], ['pays' => 'Burundi'], ['pays' => 'Cambodge'],
            ['pays' => 'Cameroun'], ['pays' => 'Canada'], ['pays' => 'Cap-Vert'],
            ['pays' => 'Chili'], ['pays' => 'Chine'], ['pays' => 'Chypre'],
            ['pays' => 'Colombie'], ['pays' => 'Comores'], ['pays' => 'Congo-Brazzaville'],
            ['pays' => 'Congo-Kinshasa'], ['pays' => 'Corée du Nord'], ['pays' => 'Corée du Sud'],
            ['pays' => 'Costa Rica'], ['pays' => 'Côte d’Ivoire'], ['pays' => 'Croatie'],
            ['pays' => 'Cuba'], ['pays' => 'Danemark'], ['pays' => 'Djibouti'],
            ['pays' => 'Dominique'], ['pays' => 'Égypte'], ['pays' => 'Émirats arabes unis'],
            ['pays' => 'Équateur'], ['pays' => 'Érythrée'], ['pays' => 'Espagne'],
            ['pays' => 'Estonie'], ['pays' => 'Eswatini'], ['pays' => 'États-Unis'],
            ['pays' => 'Éthiopie'], ['pays' => 'Fidji'], ['pays' => 'Finlande'],
            ['pays' => 'France'], ['pays' => 'Gabon'], ['pays' => 'Gambie'],
            ['pays' => 'Géorgie'], ['pays' => 'Ghana'], ['pays' => 'Grèce'],
            ['pays' => 'Grenade'], ['pays' => 'Guatemala'], ['pays' => 'Guinée'],
            ['pays' => 'Guinée équatoriale'], ['pays' => 'Guinée-Bissau'], ['pays' => 'Guyana'],
            ['pays' => 'Haïti'], ['pays' => 'Honduras'], ['pays' => 'Hongrie'],
            ['pays' => 'Inde'], ['pays' => 'Indonésie'], ['pays' => 'Irak'],
            ['pays' => 'Iran'], ['pays' => 'Irlande'], ['pays' => 'Islande'],
            ['pays' => 'Israël'], ['pays' => 'Italie'], ['pays' => 'Jamaïque'],
            ['pays' => 'Japon'], ['pays' => 'Jordanie'], ['pays' => 'Kazakhstan'],
            ['pays' => 'Kenya'], ['pays' => 'Kirghizistan'], ['pays' => 'Kiribati'],
            ['pays' => 'Koweït'], ['pays' => 'Laos'], ['pays' => 'Lesotho'],
            ['pays' => 'Lettonie'], ['pays' => 'Liban'], ['pays' => 'Libéria'],
            ['pays' => 'Libye'], ['pays' => 'Liechtenstein'], ['pays' => 'Lituanie'],
            ['pays' => 'Luxembourg'], ['pays' => 'Macédoine du Nord'], ['pays' => 'Madagascar'],
            ['pays' => 'Malaisie'], ['pays' => 'Malawi'], ['pays' => 'Maldives'],
            ['pays' => 'Mali'], ['pays' => 'Malte'], ['pays' => 'Maroc'],
            ['pays' => 'Maurice'], ['pays' => 'Mauritanie'], ['pays' => 'Mexique'],
            ['pays' => 'Micronésie'], ['pays' => 'Moldavie'], ['pays' => 'Monaco'],
            ['pays' => 'Mongolie'], ['pays' => 'Monténégro'], ['pays' => 'Mozambique'],
            ['pays' => 'Namibie'], ['pays' => 'Nauru'], ['pays' => 'Népal'],
            ['pays' => 'Nicaragua'], ['pays' => 'Niger'], ['pays' => 'Nigéria'],
            ['pays' => 'Norvège'], ['pays' => 'Nouvelle-Zélande'], ['pays' => 'Oman'],
            ['pays' => 'Ouganda'], ['pays' => 'Ouzbékistan'], ['pays' => 'Pakistan'],
            ['pays' => 'Palaos'], ['pays' => 'Palestine'], ['pays' => 'Panama'],
            ['pays' => 'Papouasie-Nouvelle-Guinée'], ['pays' => 'Paraguay'], ['pays' => 'Pays-Bas'],
            ['pays' => 'Pérou'], ['pays' => 'Philippines'], ['pays' => 'Pologne'],
            ['pays' => 'Portugal'], ['pays' => 'Qatar'], ['pays' => 'Roumanie'],
            ['pays' => 'Royaume-Uni'], ['pays' => 'Russie'], ['pays' => 'Rwanda'],
            ['pays' => 'Saint-Christophe-et-Niévès'], ['pays' => 'Sainte-Lucie'], ['pays' => 'Saint-Marin'],
            ['pays' => 'Saint-Vincent-et-les-Grenadines'], ['pays' => 'Salomon'], ['pays' => 'Salvador'],
            ['pays' => 'Samoa'], ['pays' => 'Sao Tomé-et-Principe'], ['pays' => 'Sénégal'],
            ['pays' => 'Serbie'], ['pays' => 'Seychelles'], ['pays' => 'Sierra Leone'],
            ['pays' => 'Singapour'], ['pays' => 'Slovaquie'], ['pays' => 'Slovénie'],
            ['pays' => 'Somalie'], ['pays' => 'Soudan'], ['pays' => 'Soudan du Sud'],
            ['pays' => 'Sri Lanka'], ['pays' => 'Suède'], ['pays' => 'Suisse'],
            ['pays' => 'Suriname'], ['pays' => 'Syrie'], ['pays' => 'Tadjikistan'],
            ['pays' => 'Tanzanie'], ['pays' => 'Tchad'], ['pays' => 'Tchéquie'],
            ['pays' => 'Thaïlande'], ['pays' => 'Timor oriental'], ['pays' => 'Togo'],
            ['pays' => 'Tonga'], ['pays' => 'Trinité-et-Tobago'], ['pays' => 'Tunisie'],
            ['pays' => 'Turkménistan'], ['pays' => 'Turquie'], ['pays' => 'Tuvalu'],
            ['pays' => 'Ukraine'], ['pays' => 'Uruguay'], ['pays' => 'Vanuatu'],
            ['pays' => 'Vatican'], ['pays' => 'Venezuela'], ['pays' => 'Vietnam'],
            ['pays' => 'Yémen'], ['pays' => 'Zambie'], ['pays' => 'Zimbabwe'],
            ];

            DB::table('pays')->insert($pays);
    }
}
