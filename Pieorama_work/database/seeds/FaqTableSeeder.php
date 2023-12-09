<?php

use Illuminate\Database\Seeder;
use App\Models\Faq;
class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faq::create([
            'question' => 'About Working Capital Loans',
            'answer' => '<li>Working Capital loans (also referred to as short term loans) are loans that are taken to finance the everyday operations of a company. &nbsp;</li>
                <li>Typically working capital loans can be used to grow, expand or innovate.</li>
                <li>Examples of working capital loan uses include hiring staff, purchasing inventory and payroll amongst others.</li>',
        ]);

        Faq::create([
            'question' => 'About Plendify',
            'answer' => '<li>Plendify is passionate about businesses. We are extremely supportive of entrepreneurs who provide enormous value through their businesses.&nbsp;</li>
               <li>Our mission is to create &nbsp;stable employment, stable communities and prosperous nations in Africa &nbsp;by providing businesses access to working capital.</li>',
        ]);


        Faq::create([
            'question' => 'Why do businesses trust Plendify?',
            'answer' => '<li>It is a well known fact, that the biggest challenge facing small and medium sized businesses today, is access to credit. Plendify is trusted because we are focused on providing working capital to businesses so they can invest in new equipment, launch marketing initiatives and innovate.&nbsp;</li>',
        ]);


        Faq::create([
            'question' => 'Application Process',
            'answer' => ' <li>The application process is simple and fast. You can quickly complete our mobile application form in 10 minutes. If you are applying for GHC 10,000 or less, you need to meet the below criteria:</li>
                <li><em>2 years in operation</em></li>
                <li><em>Registered business in Ghana</em></li>
                <li><em>GHC 100,000 in annual revenue</em></li>
                <li><em>Prior year Financial Statements</em></li>
                <li><em>3 months of Bank Statements</em></li>',
        ]);


        Faq::create([
            'question' => 'How Fast Will I Get A Decision?',
            'answer' => '<li>We know how critical speed is to a business owner. Provided you give us all the required information accurately, we will aim to provide you with a decision in a matter of seconds. You will receive one of these 3 decisions – “Approved”, “Approved Conditionally” and “Declined”.&nbsp;</li>
                <li>If you’re are “Approved Conditionally”, we will give you a call to verify a few details and make a funding decision thereafter.</li>
                <li>If you’re “Declined”, we would not leave you hanging. We are passionate about helping businesses, so we would love to work with you over a 6 month period to get your business ready for financing in the future.&nbsp;</li>
                                                     ',
        ]);


        Faq::create([
            'question' => 'How Quickly Will I Get My Funds?',
            'answer' => '<li>If you apply before 4pm on a business day and are approved, we will credit your bank account or mobile money wallet within 24 to 48 hours.</li>',
        ]);


        Faq::create([
            'question' => 'Fees',
            'answer' => ' <li>There are no hidden fees for our working capital loans, and you’ll know exactly how much you need to pay and when from day one.</li>
               <li>We charge an Origination fee. This fee is to help us keep the lights on and our technology running smoothly to serve you. This fee is between 1% and 5% of your approved working capital loan.</li>
               <li>We charge an attractive interest rate. This rate is approximately 3% on your working capital loan (the principal).</li>
               <li>&nbsp;There is no compounding interest, no penalties for early repayment and no additional fees (as long as you make your repayments on time)!</li>',
        ]);


         Faq::create([
            'question' => 'Repayments',
            'answer' => '<li>There are no additional fees for early repayment and no balloon payment at the end of your loan. Right from the start you will know the total amount due and the date of your final payment. Once you make the final payment your balance will be $0.</li>
                <li>To help you avoid missing repayments we offer repayments that fit in with your cash flow cycle – either daily or weekly. These are automatically deducted from your nominated business account or mobile money wallet.</li>',
        ]);

        Faq::create([
            'question' => 'Security & Privacy',
            'answer' => '<li>Plendify is big on security and ensuring privacy. We take our commitment to protecting your information very seriously. To that end, We use industry recognized encryption standards to protect your personal, sensitive and financial data. You can view our Privacy Policy.</li>',
        ]);

    }
}
