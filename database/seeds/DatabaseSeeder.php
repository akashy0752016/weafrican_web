<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BussinessCategoriesTableSeeder::class);
        $this->call(SubscriptionPlansTableSeeder::class);
        $this->call(CmsPagesTableSeeder::class);
        $this->call(CountryListsTableSeeder::class);
        $this->call(EventSeatingPlanSeeder::class);
        $this->call(UserBusinessesTableSeeder::class);
        $this->call(SubscriptionPlansTableSeeder::class);
        $this->call(SecurityQuestionsTableSeeder::class);
        $this->call(EventCategorySeeder::class);
        $this->call(UserPortfoliosSeeder::class);
        $this->call(BusinessEventsTableSeeder::class);
        $this->call(BusinessFollowersTableSeeder::class);
        $this->call(BusinessLikesTableSeeder::class);
        $this->call(BusinessProductsTableSeeder::class);
        $this->call(BusinessRatingsTableSeeder::class);
        $this->call(BusinessReviewsTableSeeder::class);
        $this->call(BusinessServicesTableSeeder::class);
        $this->call(BusinessFavouritesTableSeeder::class);
        $this->call(UserBusinessEventSeeder::class);
        $this->call(UserSubscriptionPlansTableSeeder::class);
        $this->call(BusinessVideosTableSeeder::class);
    }
}
