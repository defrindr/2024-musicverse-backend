<?php

namespace Database\Seeders;

use App\Models\Web\WebFaq;
use Illuminate\Database\Seeder;

class WebFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebFaq::create(['question' => 'Question 1', 'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, velit sequi. Officia dolor consectetur, ut iure fuga vero magni! Ea temporibus aliquam commodi optio? Vero aut necessitatibus vitae sequi tempora.']);
        WebFaq::create(['question' => 'Question 2', 'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, velit sequi. Officia dolor consectetur, ut iure fuga vero magni! Ea temporibus aliquam commodi optio? Vero aut necessitatibus vitae sequi tempora.']);
        WebFaq::create(['question' => 'Question 3', 'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, velit sequi. Officia dolor consectetur, ut iure fuga vero magni! Ea temporibus aliquam commodi optio? Vero aut necessitatibus vitae sequi tempora.']);
        WebFaq::create(['question' => 'Question 4', 'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, velit sequi. Officia dolor consectetur, ut iure fuga vero magni! Ea temporibus aliquam commodi optio? Vero aut necessitatibus vitae sequi tempora.']);
    }
}
