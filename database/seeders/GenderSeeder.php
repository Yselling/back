<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = array(
            "Homme",
            "Femme",
            "Non-binaire",
            "Genre fluide",
            "Agender",
            "Genrequeer",
            "Genre non conforme",
            "Deux-esprits",
            "Bigenre",
            "Androgyne",
            "Transgenre",
            "Genderqueer",
            "Genre neutre",
            "Genreflux",
            "Questionnement de genre",
            "Demi-genre",
            "Pangenre",
            "Tiers-genre",
            "Agender",
            "Autre",
            "Polygenre",
            "Intergenre",
            "Neutrois",
            "Graygen",
            "Genderfluid",
            "Genderpunky",
            "Femme trans",
            "Homme trans",
            "Personne trans",
            "Genderqueerflux",
            "Genderfluidflux",
            "Xenogender",
            "Egender",
            "Surgenre",
            "Subgenre",
            "Non-binaire hémigirl",
            "Non-binaire hémiguy",
            "Non-binaire hémienby",
            "Boyflux",
            "Girlflux",
            "Juxera",
            "Virgender",
            "Valide",
            "Nonvalide",
            "Novigender",
            "Gendermaverick",
            "Fémégender",
            "Masculigender",
            "Non-binaire masculin",
            "Non-binaire féminin",
            "Femandrogyne",
            "Mascandrogyne",
            "Intergenreflux"
        );

        foreach ($genders as $genre)
        {
            Gender::factory(100)->create([
                'name' => $genre,
            ]);
        }
    }
}
