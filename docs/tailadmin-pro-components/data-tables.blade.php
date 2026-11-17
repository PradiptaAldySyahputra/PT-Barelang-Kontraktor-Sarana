<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Data Tables
    </h2>
    <nav>
        <ol class="flex items-center gap-1.5">
            <li>
                <a
                    class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                    href="https://laravel-demo.tailadmin.com"
                >
                    Home
                    <svg
                        class="stroke-current rtl:rotate-180"
                        width="17"
                        height="16"
                        viewBox="0 0 17 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                            stroke=""
                            stroke-width="1.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>
            </li>
            <li class="text-sm text-gray-800 dark:text-white/90">
                Data Tables
            </li>
        </ol>
    </nav>
</div>
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Data Table 1
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div data-slot="card" data-size="default" x-data="tanstackTable('table-one', JSON.parse('{\u0022rows\u0022:[{\u0022id\u0022:1,\u0022user\u0022:{\u0022name\u0022:\u0022Lindsey Curtis\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-01.jpg\u0022,\u0022initials\u0022:\u0022LC\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:33,\u0022startDate\u0022:\u002212 Feb, 2027\u0022,\u0022salary\u0022:\u0022$168,500\u0022},{\u0022id\u0022:2,\u0022user\u0022:{\u0022name\u0022:\u0022Kaiya George\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-02.jpg\u0022,\u0022initials\u0022:\u0022KG\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:66,\u0022startDate\u0022:\u002213 Mar, 2027\u0022,\u0022salary\u0022:\u0022$23,500\u0022},{\u0022id\u0022:3,\u0022user\u0022:{\u0022name\u0022:\u0022Zain Geidt\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-03.jpg\u0022,\u0022initials\u0022:\u0022ZG\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022Tokyo\u0022,\u0022age\u0022:48,\u0022startDate\u0022:\u002219 Mar, 2027\u0022,\u0022salary\u0022:\u0022$12,500\u0022},{\u0022id\u0022:4,\u0022user\u0022:{\u0022name\u0022:\u0022Abram Schleifer\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-04.jpg\u0022,\u0022initials\u0022:\u0022AS\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022Edinburgh\u0022,\u0022age\u0022:57,\u0022startDate\u0022:\u002225 Apr, 2027\u0022,\u0022salary\u0022:\u0022$89,500\u0022},{\u0022id\u0022:5,\u0022user\u0022:{\u0022name\u0022:\u0022Carla George\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-05.jpg\u0022,\u0022initials\u0022:\u0022CG\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:45,\u0022startDate\u0022:\u002211 May, 2027\u0022,\u0022salary\u0022:\u0022$15,500\u0022},{\u0022id\u0022:6,\u0022user\u0022:{\u0022name\u0022:\u0022Emery Culhane\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-06.jpg\u0022,\u0022initials\u0022:\u0022EC\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:45,\u0022startDate\u0022:\u002229 Jun, 2027\u0022,\u0022salary\u0022:\u0022$23,500\u0022},{\u0022id\u0022:7,\u0022user\u0022:{\u0022name\u0022:\u0022Livia Donin\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-07.jpg\u0022,\u0022initials\u0022:\u0022LD\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:26,\u0022startDate\u0022:\u002222 Jul, 2027\u0022,\u0022salary\u0022:\u0022$58,500\u0022},{\u0022id\u0022:8,\u0022user\u0022:{\u0022name\u0022:\u0022Miracle Bator\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-08.jpg\u0022,\u0022initials\u0022:\u0022MB\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022Tokyo\u0022,\u0022age\u0022:53,\u0022startDate\u0022:\u002205 Aug, 2027\u0022,\u0022salary\u0022:\u0022$34,900\u0022},{\u0022id\u0022:9,\u0022user\u0022:{\u0022name\u0022:\u0022Lincoln Herwitz\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-09.jpg\u0022,\u0022initials\u0022:\u0022LH\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:38,\u0022startDate\u0022:\u002209 Sep, 2027\u0022,\u0022salary\u0022:\u0022$18,300\u0022},{\u0022id\u0022:10,\u0022user\u0022:{\u0022name\u0022:\u0022Ekstrom Bothman\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-10.jpg\u0022,\u0022initials\u0022:\u0022EB\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:34,\u0022startDate\u0022:\u002215 Nov, 2027\u0022,\u0022salary\u0022:\u0022$19,200\u0022},{\u0022id\u0022:11,\u0022user\u0022:{\u0022name\u0022:\u0022Sophia Martinez\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-11.jpg\u0022,\u0022initials\u0022:\u0022SM\u0022},\u0022position\u0022:\u0022Product Designer\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:29,\u0022startDate\u0022:\u002210 Jan, 2026\u0022,\u0022salary\u0022:\u0022$92,000\u0022},{\u0022id\u0022:12,\u0022user\u0022:{\u0022name\u0022:\u0022James Wilson\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-12.jpg\u0022,\u0022initials\u0022:\u0022JW\u0022},\u0022position\u0022:\u0022Software Engineer\u0022,\u0022office\u0022:\u0022Chicago\u0022,\u0022age\u0022:31,\u0022startDate\u0022:\u002214 Feb, 2026\u0022,\u0022salary\u0022:\u0022$115,000\u0022},{\u0022id\u0022:13,\u0022user\u0022:{\u0022name\u0022:\u0022Olivia Johnson\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-13.jpg\u0022,\u0022initials\u0022:\u0022OJ\u0022},\u0022position\u0022:\u0022Data Analyst\u0022,\u0022office\u0022:\u0022Los Angeles\u0022,\u0022age\u0022:28,\u0022startDate\u0022:\u002221 Mar, 2026\u0022,\u0022salary\u0022:\u0022$88,000\u0022},{\u0022id\u0022:14,\u0022user\u0022:{\u0022name\u0022:\u0022William Smith\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-14.jpg\u0022,\u0022initials\u0022:\u0022WS\u0022},\u0022position\u0022:\u0022Marketing Manager\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:41,\u0022startDate\u0022:\u002204 Apr, 2026\u0022,\u0022salary\u0022:\u0022$104,000\u0022},{\u0022id\u0022:15,\u0022user\u0022:{\u0022name\u0022:\u0022Isabella Davis\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-15.jpg\u0022,\u0022initials\u0022:\u0022ID\u0022},\u0022position\u0022:\u0022UI\\\/UX Designer\u0022,\u0022office\u0022:\u0022Austin\u0022,\u0022age\u0022:27,\u0022startDate\u0022:\u002218 May, 2026\u0022,\u0022salary\u0022:\u0022$96,000\u0022},{\u0022id\u0022:16,\u0022user\u0022:{\u0022name\u0022:\u0022Liam Moore\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-16.jpg\u0022,\u0022initials\u0022:\u0022LM\u0022},\u0022position\u0022:\u0022DevOps Engineer\u0022,\u0022office\u0022:\u0022Boston\u0022,\u0022age\u0022:35,\u0022startDate\u0022:\u002230 Jun, 2026\u0022,\u0022salary\u0022:\u0022$125,000\u0022},{\u0022id\u0022:17,\u0022user\u0022:{\u0022name\u0022:\u0022Mia Garcia\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022,\u0022initials\u0022:\u0022MG\u0022},\u0022position\u0022:\u0022Content Strategist\u0022,\u0022office\u0022:\u0022Denver\u0022,\u0022age\u0022:30,\u0022startDate\u0022:\u002212 Jul, 2026\u0022,\u0022salary\u0022:\u0022$74,000\u0022},{\u0022id\u0022:18,\u0022user\u0022:{\u0022name\u0022:\u0022Ethan Brown\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022,\u0022initials\u0022:\u0022EB\u0022},\u0022position\u0022:\u0022Solutions Architect\u0022,\u0022office\u0022:\u0022Seattle\u0022,\u0022age\u0022:44,\u0022startDate\u0022:\u002228 Aug, 2026\u0022,\u0022salary\u0022:\u0022$142,000\u0022},{\u0022id\u0022:19,\u0022user\u0022:{\u0022name\u0022:\u0022Charlotte Anderson\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-19.jpg\u0022,\u0022initials\u0022:\u0022CA\u0022},\u0022position\u0022:\u0022Product Manager\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:36,\u0022startDate\u0022:\u002216 Sep, 2026\u0022,\u0022salary\u0022:\u0022$130,000\u0022},{\u0022id\u0022:20,\u0022user\u0022:{\u0022name\u0022:\u0022Noah Taylor\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-20.jpg\u0022,\u0022initials\u0022:\u0022NT\u0022},\u0022position\u0022:\u0022Frontend Developer\u0022,\u0022office\u0022:\u0022Berlin\u0022,\u0022age\u0022:29,\u0022startDate\u0022:\u002202 Oct, 2026\u0022,\u0022salary\u0022:\u0022$85,000\u0022},{\u0022id\u0022:21,\u0022user\u0022:{\u0022name\u0022:\u0022Amelia Thomas\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-21.jpg\u0022,\u0022initials\u0022:\u0022AT\u0022},\u0022position\u0022:\u0022QA Engineer\u0022,\u0022office\u0022:\u0022Toronto\u0022,\u0022age\u0022:32,\u0022startDate\u0022:\u002219 Nov, 2026\u0022,\u0022salary\u0022:\u0022$79,000\u0022},{\u0022id\u0022:22,\u0022user\u0022:{\u0022name\u0022:\u0022Lucas White\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-22.jpg\u0022,\u0022initials\u0022:\u0022LW\u0022},\u0022position\u0022:\u0022Backend Developer\u0022,\u0022office\u0022:\u0022Chicago\u0022,\u0022age\u0022:33,\u0022startDate\u0022:\u002205 Dec, 2026\u0022,\u0022salary\u0022:\u0022$110,000\u0022},{\u0022id\u0022:23,\u0022user\u0022:{\u0022name\u0022:\u0022Harper Harris\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-23.jpg\u0022,\u0022initials\u0022:\u0022HH\u0022},\u0022position\u0022:\u0022Graphic Designer\u0022,\u0022office\u0022:\u0022Miami\u0022,\u0022age\u0022:25,\u0022startDate\u0022:\u002214 Jan, 2027\u0022,\u0022salary\u0022:\u0022$68,000\u0022},{\u0022id\u0022:24,\u0022user\u0022:{\u0022name\u0022:\u0022Mason Clark\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-24.jpg\u0022,\u0022initials\u0022:\u0022MC\u0022},\u0022position\u0022:\u0022System Administrator\u0022,\u0022office\u0022:\u0022Dallas\u0022,\u0022age\u0022:39,\u0022startDate\u0022:\u002222 Feb, 2027\u0022,\u0022salary\u0022:\u0022$94,000\u0022},{\u0022id\u0022:25,\u0022user\u0022:{\u0022name\u0022:\u0022Evelyn Lewis\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-25.jpg\u0022,\u0022initials\u0022:\u0022EL\u0022},\u0022position\u0022:\u0022HR Manager\u0022,\u0022office\u0022:\u0022Atlanta\u0022,\u0022age\u0022:42,\u0022startDate\u0022:\u002210 Mar, 2027\u0022,\u0022salary\u0022:\u0022$86,000\u0022},{\u0022id\u0022:26,\u0022user\u0022:{\u0022name\u0022:\u0022Alexander Robinson\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-26.jpg\u0022,\u0022initials\u0022:\u0022AR\u0022},\u0022position\u0022:\u0022Business Analyst\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:37,\u0022startDate\u0022:\u002201 Apr, 2027\u0022,\u0022salary\u0022:\u0022$98,000\u0022},{\u0022id\u0022:27,\u0022user\u0022:{\u0022name\u0022:\u0022Abigail Walker\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-27.jpg\u0022,\u0022initials\u0022:\u0022AW\u0022},\u0022position\u0022:\u0022Financial Planner\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:46,\u0022startDate\u0022:\u002217 May, 2027\u0022,\u0022salary\u0022:\u0022$112,000\u0022},{\u0022id\u0022:28,\u0022user\u0022:{\u0022name\u0022:\u0022Daniel Young\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-28.jpg\u0022,\u0022initials\u0022:\u0022DY\u0022},\u0022position\u0022:\u0022Operations Lead\u0022,\u0022office\u0022:\u0022Sydney\u0022,\u0022age\u0022:40,\u0022startDate\u0022:\u002225 Jun, 2027\u0022,\u0022salary\u0022:\u0022$108,000\u0022},{\u0022id\u0022:29,\u0022user\u0022:{\u0022name\u0022:\u0022Emily Hall\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-29.jpg\u0022,\u0022initials\u0022:\u0022EH\u0022},\u0022position\u0022:\u0022Project Coordinator\u0022,\u0022office\u0022:\u0022Dublin\u0022,\u0022age\u0022:28,\u0022startDate\u0022:\u002209 Jul, 2027\u0022,\u0022salary\u0022:\u0022$72,000\u0022},{\u0022id\u0022:30,\u0022user\u0022:{\u0022name\u0022:\u0022Matthew Allen\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-30.jpg\u0022,\u0022initials\u0022:\u0022MA\u0022},\u0022position\u0022:\u0022Security Analyst\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:34,\u0022startDate\u0022:\u002219 Aug, 2027\u0022,\u0022salary\u0022:\u0022$122,000\u0022},{\u0022id\u0022:31,\u0022user\u0022:{\u0022name\u0022:\u0022Elizabeth King\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-31.jpg\u0022,\u0022initials\u0022:\u0022EK\u0022},\u0022position\u0022:\u0022Database Admin\u0022,\u0022office\u0022:\u0022Tokyo\u0022,\u0022age\u0022:43,\u0022startDate\u0022:\u002203 Sep, 2027\u0022,\u0022salary\u0022:\u0022$105,000\u0022},{\u0022id\u0022:32,\u0022user\u0022:{\u0022name\u0022:\u0022Henry Wright\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-32.jpg\u0022,\u0022initials\u0022:\u0022HW\u0022},\u0022position\u0022:\u0022Scrum Master\u0022,\u0022office\u0022:\u0022Edinburgh\u0022,\u0022age\u0022:38,\u0022startDate\u0022:\u002229 Sep, 2027\u0022,\u0022salary\u0022:\u0022$95,000\u0022},{\u0022id\u0022:33,\u0022user\u0022:{\u0022name\u0022:\u0022Sofia Scott\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-33.jpg\u0022,\u0022initials\u0022:\u0022SS\u0022},\u0022position\u0022:\u0022Technical Writer\u0022,\u0022office\u0022:\u0022Vancouver\u0022,\u0022age\u0022:29,\u0022startDate\u0022:\u002215 Oct, 2027\u0022,\u0022salary\u0022:\u0022$76,000\u0022},{\u0022id\u0022:34,\u0022user\u0022:{\u0022name\u0022:\u0022Jackson Green\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-34.jpg\u0022,\u0022initials\u0022:\u0022JG\u0022},\u0022position\u0022:\u0022Cloud Consultant\u0022,\u0022office\u0022:\u0022Singapore\u0022,\u0022age\u0022:36,\u0022startDate\u0022:\u002202 Nov, 2027\u0022,\u0022salary\u0022:\u0022$134,000\u0022},{\u0022id\u0022:35,\u0022user\u0022:{\u0022name\u0022:\u0022Avery Adams\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-35.jpg\u0022,\u0022initials\u0022:\u0022AA\u0022},\u0022position\u0022:\u0022Customer Success Lead\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:31,\u0022startDate\u0022:\u002220 Nov, 2027\u0022,\u0022salary\u0022:\u0022$82,000\u0022},{\u0022id\u0022:36,\u0022user\u0022:{\u0022name\u0022:\u0022Sebastian Baker\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-36.jpg\u0022,\u0022initials\u0022:\u0022SB\u0022},\u0022position\u0022:\u0022Full Stack Engineer\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:32,\u0022startDate\u0022:\u002208 Dec, 2027\u0022,\u0022salary\u0022:\u0022$118,000\u0022},{\u0022id\u0022:37,\u0022user\u0022:{\u0022name\u0022:\u0022Chloe Gonzalez\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-37.jpg\u0022,\u0022initials\u0022:\u0022CG\u0022},\u0022position\u0022:\u0022UX Researcher\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:30,\u0022startDate\u0022:\u002222 Dec, 2027\u0022,\u0022salary\u0022:\u0022$91,000\u0022},{\u0022id\u0022:38,\u0022user\u0022:{\u0022name\u0022:\u0022Jack Nelson\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-01.jpg\u0022,\u0022initials\u0022:\u0022JN\u0022},\u0022position\u0022:\u0022Sales Representative\u0022,\u0022office\u0022:\u0022Austin\u0022,\u0022age\u0022:27,\u0022startDate\u0022:\u002205 Jan, 2028\u0022,\u0022salary\u0022:\u0022$65,000\u0022},{\u0022id\u0022:39,\u0022user\u0022:{\u0022name\u0022:\u0022Ella Carter\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-02.jpg\u0022,\u0022initials\u0022:\u0022EC\u0022},\u0022position\u0022:\u0022Legal Counsel\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:45,\u0022startDate\u0022:\u002218 Jan, 2028\u0022,\u0022salary\u0022:\u0022$145,000\u0022},{\u0022id\u0022:40,\u0022user\u0022:{\u0022name\u0022:\u0022Samuel Mitchell\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-03.jpg\u0022,\u0022initials\u0022:\u0022SM\u0022},\u0022position\u0022:\u0022Product Marketer\u0022,\u0022office\u0022:\u0022Boston\u0022,\u0022age\u0022:35,\u0022startDate\u0022:\u002203 Feb, 2028\u0022,\u0022salary\u0022:\u0022$96,000\u0022},{\u0022id\u0022:41,\u0022user\u0022:{\u0022name\u0022:\u0022Victoria Perez\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-04.jpg\u0022,\u0022initials\u0022:\u0022VP\u0022},\u0022position\u0022:\u0022Sales Manager\u0022,\u0022office\u0022:\u0022Chicago\u0022,\u0022age\u0022:41,\u0022startDate\u0022:\u002217 Feb, 2028\u0022,\u0022salary\u0022:\u0022$110,000\u0022},{\u0022id\u0022:42,\u0022user\u0022:{\u0022name\u0022:\u0022David Roberts\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-05.jpg\u0022,\u0022initials\u0022:\u0022DR\u0022},\u0022position\u0022:\u0022Software Architect\u0022,\u0022office\u0022:\u0022Seattle\u0022,\u0022age\u0022:47,\u0022startDate\u0022:\u002201 Mar, 2028\u0022,\u0022salary\u0022:\u0022$158,000\u0022},{\u0022id\u0022:43,\u0022user\u0022:{\u0022name\u0022:\u0022Grace Turner\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-06.jpg\u0022,\u0022initials\u0022:\u0022GT\u0022},\u0022position\u0022:\u0022Visual Designer\u0022,\u0022office\u0022:\u0022Miami\u0022,\u0022age\u0022:26,\u0022startDate\u0022:\u002215 Mar, 2028\u0022,\u0022salary\u0022:\u0022$71,000\u0022},{\u0022id\u0022:44,\u0022user\u0022:{\u0022name\u0022:\u0022Joseph Phillips\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-07.jpg\u0022,\u0022initials\u0022:\u0022JP\u0022},\u0022position\u0022:\u0022Security Engineer\u0022,\u0022office\u0022:\u0022Dallas\u0022,\u0022age\u0022:34,\u0022startDate\u0022:\u002228 Mar, 2028\u0022,\u0022salary\u0022:\u0022$128,000\u0022},{\u0022id\u0022:45,\u0022user\u0022:{\u0022name\u0022:\u0022Zoey Campbell\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-08.jpg\u0022,\u0022initials\u0022:\u0022ZC\u0022},\u0022position\u0022:\u0022Talent Acquisition\u0022,\u0022office\u0022:\u0022Denver\u0022,\u0022age\u0022:33,\u0022startDate\u0022:\u002211 Apr, 2028\u0022,\u0022salary\u0022:\u0022$78,000\u0022},{\u0022id\u0022:46,\u0022user\u0022:{\u0022name\u0022:\u0022Carter Parker\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-09.jpg\u0022,\u0022initials\u0022:\u0022CP\u0022},\u0022position\u0022:\u0022Network Engineer\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:38,\u0022startDate\u0022:\u002226 Apr, 2028\u0022,\u0022salary\u0022:\u0022$102,000\u0022},{\u0022id\u0022:47,\u0022user\u0022:{\u0022name\u0022:\u0022Penelope Evans\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-10.jpg\u0022,\u0022initials\u0022:\u0022PE\u0022},\u0022position\u0022:\u0022Brand Manager\u0022,\u0022office\u0022:\u0022Los Angeles\u0022,\u0022age\u0022:36,\u0022startDate\u0022:\u002209 May, 2028\u0022,\u0022salary\u0022:\u0022$97,000\u0022},{\u0022id\u0022:48,\u0022user\u0022:{\u0022name\u0022:\u0022Luke Edwards\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-11.jpg\u0022,\u0022initials\u0022:\u0022LE\u0022},\u0022position\u0022:\u0022Mobile Developer\u0022,\u0022office\u0022:\u0022Berlin\u0022,\u0022age\u0022:30,\u0022startDate\u0022:\u002224 May, 2028\u0022,\u0022salary\u0022:\u0022$90,000\u0022},{\u0022id\u0022:49,\u0022user\u0022:{\u0022name\u0022:\u0022Riley Collins\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-12.jpg\u0022,\u0022initials\u0022:\u0022RC\u0022},\u0022position\u0022:\u0022Financial Analyst\u0022,\u0022office\u0022:\u0022Tokyo\u0022,\u0022age\u0022:29,\u0022startDate\u0022:\u002207 Jun, 2028\u0022,\u0022salary\u0022:\u0022$87,000\u0022},{\u0022id\u0022:50,\u0022user\u0022:{\u0022name\u0022:\u0022Owen Stewart\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-13.jpg\u0022,\u0022initials\u0022:\u0022OS\u0022},\u0022position\u0022:\u0022Automation Tester\u0022,\u0022office\u0022:\u0022Toronto\u0022,\u0022age\u0022:31,\u0022startDate\u0022:\u002221 Jun, 2028\u0022,\u0022salary\u0022:\u0022$84,000\u0022},{\u0022id\u0022:51,\u0022user\u0022:{\u0022name\u0022:\u0022Nora Sanchez\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-14.jpg\u0022,\u0022initials\u0022:\u0022NS\u0022},\u0022position\u0022:\u0022Office Manager\u0022,\u0022office\u0022:\u0022Edinburgh\u0022,\u0022age\u0022:40,\u0022startDate\u0022:\u002208 Jul, 2028\u0022,\u0022salary\u0022:\u0022$68,000\u0022},{\u0022id\u0022:52,\u0022user\u0022:{\u0022name\u0022:\u0022Wyatt Morris\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-15.jpg\u0022,\u0022initials\u0022:\u0022WM\u0022},\u0022position\u0022:\u0022Support Specialist\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:27,\u0022startDate\u0022:\u002223 Jul, 2028\u0022,\u0022salary\u0022:\u0022$60,000\u0022},{\u0022id\u0022:53,\u0022user\u0022:{\u0022name\u0022:\u0022Lily Rogers\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-16.jpg\u0022,\u0022initials\u0022:\u0022LR\u0022},\u0022position\u0022:\u0022Marketing Specialist\u0022,\u0022office\u0022:\u0022Dublin\u0022,\u0022age\u0022:28,\u0022startDate\u0022:\u002205 Aug, 2028\u0022,\u0022salary\u0022:\u0022$73,000\u0022},{\u0022id\u0022:54,\u0022user\u0022:{\u0022name\u0022:\u0022Julian Reed\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022,\u0022initials\u0022:\u0022JR\u0022},\u0022position\u0022:\u0022Product Analyst\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:33,\u0022startDate\u0022:\u002219 Aug, 2028\u0022,\u0022salary\u0022:\u0022$89,000\u0022},{\u0022id\u0022:55,\u0022user\u0022:{\u0022name\u0022:\u0022Hannah Cook\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022,\u0022initials\u0022:\u0022HC\u0022},\u0022position\u0022:\u0022Billing Specialist\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:35,\u0022startDate\u0022:\u002202 Sep, 2028\u0022,\u0022salary\u0022:\u0022$70,000\u0022},{\u0022id\u0022:56,\u0022user\u0022:{\u0022name\u0022:\u0022Levi Morgan\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-19.jpg\u0022,\u0022initials\u0022:\u0022LM\u0022},\u0022position\u0022:\u0022Lead Architect\u0022,\u0022office\u0022:\u0022Austin\u0022,\u0022age\u0022:46,\u0022startDate\u0022:\u002218 Sep, 2028\u0022,\u0022salary\u0022:\u0022$165,000\u0022},{\u0022id\u0022:57,\u0022user\u0022:{\u0022name\u0022:\u0022Stella Bell\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-20.jpg\u0022,\u0022initials\u0022:\u0022SB\u0022},\u0022position\u0022:\u0022Executive Assistant\u0022,\u0022office\u0022:\u0022Chicago\u0022,\u0022age\u0022:37,\u0022startDate\u0022:\u002230 Sep, 2028\u0022,\u0022salary\u0022:\u0022$76,500\u0022}]}'))" class="group/card flex flex-col data-[size=sm]:p-4 w-full max-w-full min-w-0 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 sm:p-0 dark:border-gray-800 dark:bg-white/3"><!-- Table Top Controls -->
    <div class="flex flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
    <!-- Page Size Selector -->
    <div class="flex items-center gap-3">
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400"> Show </span>
        <div class="w-18.5 shrink-0">
            <div data-slot="select" data-ui-root x-data="uiSelect(JSON.parse('{\u0022value\u0022:\u002210\u0022,\u0022multiple\u0022:false}'))" class="contents" @change="if ($event.detail.value) setPageSize(Number($event.detail.value))"><button type="button" role="combobox" aria-haspopup="listbox" aria-expanded="false" data-slot="select-trigger" data-size="sm" data-state="closed"
    x-ref="trigger" x-bind:id="id + '-trigger'" x-bind:aria-expanded="open ? 'true' : 'false'" x-bind:data-state="state" x-bind:data-popup-open="open ? '' : null"
    x-bind:data-placeholder="label == null ? '' : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)"
    aria-label="Select entries per page" class="group/select-trigger flex min-w-0 items-center justify-between gap-2 border py-2.5 outline-hidden transition-all duration-200 select-none hover:bg-gray-50/50 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-invalid:border-red-500 data-invalid:ring-3 data-invalid:ring-red-500/20 data-popup-open:border-brand-300 data-popup-open:ring-3 data-popup-open:ring-brand-500/20 data-[size=default]:h-11 data-[size=default]:rounded-[10px] data-[size=lg]:h-12 data-[size=lg]:rounded-[10px] data-[size=lg]:py-3 data-[size=lg]:ps-4.5 data-[size=lg]:pe-3.5 data-[size=sm]:h-9 data-[size=sm]:rounded-lg data-[size=sm]:py-2 data-[size=sm]:ps-3.5 data-[size=sm]:pe-2.5 dark:hover:bg-gray-800/50 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:data-popup-open:border-brand-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 h-9 w-full rounded-lg border-gray-300 bg-white px-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:border-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:border-gray-600">
    <span data-slot="select-value" 
    class="flex flex-1 items-center gap-2 truncate text-start text-gray-800 group-data-placeholder/select-trigger:text-gray-400 dark:text-white/90 dark:group-data-placeholder/select-trigger:text-gray-500"
    x-text="label ?? ''"></span>
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 group-hover/select-trigger:text-gray-700 group-data-popup-open/select-trigger:rotate-180 dark:text-gray-400 dark:group-hover/select-trigger:text-gray-300">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="listbox" tabindex="-1" style="outline: none;" x-bind:id="id" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="start"
            data-slot="select-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:0}" x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-select-content-available-height) min-w-(--reka-select-trigger-width) origin-(--reka-select-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-18.5 rounded-lg p-1">
            <div class="flex flex-col gap-1 outline-none"><div role="option" tabindex="-1" data-slot="select-item" data-value="5"     x-init="register('5', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('5') ? 'true' : 'false'" x-bind:data-state="isSelected('5') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('5')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">5</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('5')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="10"     x-init="register('10', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('10') ? 'true' : 'false'" x-bind:data-state="isSelected('10') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('10')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">10</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('10')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="20"     x-init="register('20', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('20') ? 'true' : 'false'" x-bind:data-state="isSelected('20') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('20')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">20</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('20')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="50"     x-init="register('50', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('50') ? 'true' : 'false'" x-bind:data-state="isSelected('50') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('50')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">50</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('50')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div></div>
        </div>
    </div>
</template></div>
        </div>
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400"> entries </span>
    </div>

            <!-- Global Search Input -->
        <div class="w-full sm:w-64 md:w-72">
            <div data-slot="input-group" role="group"  class="group/input-group relative flex w-full min-w-0 items-center border bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-10 rounded-[10px] border-gray-300 dark:border-gray-700"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5 ps-3.5 pe-0"><svg class="size-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></div>
                <input type="text" data-slot="input-group-control" placeholder="Search..." x-model="searchQuery" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0 text-sm placeholder:text-gray-400 dark:placeholder:text-gray-500"></div>
        </div>
    </div>

    <!-- Table Content -->
    <div class="max-w-full overflow-x-auto">
        <div class="min-w-175 2xl:min-w-202">
            <table class="min-w-full">
                <thead class="border-y border-gray-200 bg-gray-50/75 dark:border-gray-800 dark:bg-gray-900/50">
                    <tr>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('user')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">User</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('user') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('user') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('position')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Position</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('position') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('position') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('office')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Office</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('office') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('office') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('age')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Age</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('age') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('age') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('startDate')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Start date</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('startDate') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('startDate') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="px-4 py-3 sm:px-6">
                            <button type="button" @click="toggleSorting('salary')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Salary</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('salary') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('salary') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr x-show="rows.length === 0" style="display: none;">
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="mb-3 flex size-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6 text-gray-800 dark:text-white/90">
    <path
      d="M12 21.072V11.029m0 0c-.23 0-.46-.053-.67-.159m.67.159c.23 0 .46-.053.671-.159m0 0a1.5 1.5 0 01-1.341 0m1.341 0l7.55-3.774M11.33 10.87L3.78 7.096m16.441 0a1.499 1.499 0 00-.592-.533L12.67 3.084a1.5 1.5 0 00-1.341 0L4.372 6.563c-.247.123-.45.309-.592.533m16.441 0a1.5 1.5 0 01.237.808v8.19a1.5 1.5 0 01-.83 1.341l-6.957 3.479a1.5 1.5 0 01-1.341 0l-6.958-3.479a1.5 1.5 0 01-.829-1.342V7.904c0-.292.085-.571.237-.808"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                    </div>
                                    <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">No entries found</h4>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search to find what you're looking for.</p>
                                </div>
                            </td>
                        </tr>
                    <template x-for="row in rows" :key="row.id">
                        <tr class="border-b border-gray-200 last:border-b-0 transition-colors hover:bg-gray-50/50 dark:border-gray-800 dark:hover:bg-white/2">
                            <!-- User Cell -->
                            <td class="border-e border-gray-200 px-4 py-3.5 sm:px-6 dark:border-gray-800">
                                <div class="flex items-center gap-3">
                                    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-10"><template x-if="row.user.image">
                                            <img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" x-bind:src="row.user.image" x-bind:alt="row.user.name" class="aspect-square size-full rounded-full object-cover">
                                        </template>
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400 text-xs font-semibold select-none"><span x-text="row.user.initials ?? row.user.name.split(' ').map((n) => n[0]).slice(0, 2).join('').toUpperCase()"></span></span>
</template></span>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="row.user.name"></span>
                                </div>
                            </td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.position"></span></td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.office"></span></td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.age"></span></td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.startDate"></span></td>
                            <td class="px-4 py-3.5 text-start sm:px-6"><span class="text-sm font-medium text-gray-800 dark:text-gray-200" x-text="row.salary"></span></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table Footer Pagination -->
    <div class="flex flex-col gap-4 border-t border-gray-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-gray-800">
            <!-- Entries Info -->
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Showing <span x-text="startEntry"></span> to <span x-text="endEntry"></span> of <span x-text="totalEntries"></span> entries
        </p>
    
    <div x-show="totalPages > 0" class="flex items-center gap-1.5 self-center sm:self-auto">
        <!-- Previous Button -->
        <button type="button" :disabled="pageIndex <= 0" class="flex size-10 items-center justify-center rounded-[10px] border border-gray-200 bg-white text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5" aria-label="Previous page" @click="goPage(pageIndex - 1)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
        </button>

        <!-- Numbered Page Buttons -->
        <div class="flex items-center gap-1.5">
            <template x-for="(item, index) in pages" :key="typeof item === 'number' ? item : `ellipsis-${index}`">
                <div>
                    <template x-if="typeof item === 'string'">
                        <span class="flex size-10 items-center justify-center text-sm font-medium text-gray-500 dark:text-gray-400">...</span>
                    </template>
                    <template x-if="typeof item === 'number'">
                        <button
                            type="button"
                            class="flex size-10 items-center justify-center rounded-[10px] text-sm font-medium transition-colors"
                            :class="currentPage === item ? 'bg-brand-500 text-white shadow-theme-xs' : 'border border-gray-200 bg-white text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5'"
                            :aria-current="currentPage === item ? 'page' : null"
                            @click="goPage(item - 1)"
                            x-text="item"
                        ></button>
                    </template>
                </div>
            </template>
        </div>

        <!-- Next Button -->
        <button type="button" :disabled="pageIndex >= totalPages - 1" class="flex size-10 items-center justify-center rounded-[10px] border border-gray-200 bg-white text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5" aria-label="Next page" @click="goPage(pageIndex + 1)">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
        </button>
    </div>

    </div></div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Data Table 2
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div data-slot="card" data-size="default" x-data="tanstackTable('table-two', JSON.parse('{\u0022rows\u0022:[{\u0022id\u0022:1,\u0022user\u0022:{\u0022name\u0022:\u0022Lindsey Curtis\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-01.jpg\u0022,\u0022initials\u0022:\u0022LC\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:33,\u0022startDate\u0022:\u002212 Feb, 2027\u0022,\u0022salary\u0022:\u0022$168,500\u0022},{\u0022id\u0022:2,\u0022user\u0022:{\u0022name\u0022:\u0022Kaiya George\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-02.jpg\u0022,\u0022initials\u0022:\u0022KG\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:66,\u0022startDate\u0022:\u002213 Mar, 2027\u0022,\u0022salary\u0022:\u0022$23,500\u0022},{\u0022id\u0022:3,\u0022user\u0022:{\u0022name\u0022:\u0022Zain Geidt\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-03.jpg\u0022,\u0022initials\u0022:\u0022ZG\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022Tokyo\u0022,\u0022age\u0022:48,\u0022startDate\u0022:\u002219 Mar, 2027\u0022,\u0022salary\u0022:\u0022$12,500\u0022},{\u0022id\u0022:4,\u0022user\u0022:{\u0022name\u0022:\u0022Abram Schleifer\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-04.jpg\u0022,\u0022initials\u0022:\u0022AS\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022Edinburgh\u0022,\u0022age\u0022:57,\u0022startDate\u0022:\u002225 Apr, 2027\u0022,\u0022salary\u0022:\u0022$89,500\u0022},{\u0022id\u0022:5,\u0022user\u0022:{\u0022name\u0022:\u0022Carla George\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-05.jpg\u0022,\u0022initials\u0022:\u0022CG\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:45,\u0022startDate\u0022:\u002211 May, 2027\u0022,\u0022salary\u0022:\u0022$15,500\u0022},{\u0022id\u0022:6,\u0022user\u0022:{\u0022name\u0022:\u0022Emery Culhane\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-06.jpg\u0022,\u0022initials\u0022:\u0022EC\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:45,\u0022startDate\u0022:\u002229 Jun, 2027\u0022,\u0022salary\u0022:\u0022$23,500\u0022},{\u0022id\u0022:7,\u0022user\u0022:{\u0022name\u0022:\u0022Livia Donin\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-07.jpg\u0022,\u0022initials\u0022:\u0022LD\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:26,\u0022startDate\u0022:\u002222 Jul, 2027\u0022,\u0022salary\u0022:\u0022$58,500\u0022},{\u0022id\u0022:8,\u0022user\u0022:{\u0022name\u0022:\u0022Miracle Bator\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-08.jpg\u0022,\u0022initials\u0022:\u0022MB\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022Tokyo\u0022,\u0022age\u0022:53,\u0022startDate\u0022:\u002205 Aug, 2027\u0022,\u0022salary\u0022:\u0022$34,900\u0022},{\u0022id\u0022:9,\u0022user\u0022:{\u0022name\u0022:\u0022Lincoln Herwitz\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-09.jpg\u0022,\u0022initials\u0022:\u0022LH\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:38,\u0022startDate\u0022:\u002209 Sep, 2027\u0022,\u0022salary\u0022:\u0022$18,300\u0022},{\u0022id\u0022:10,\u0022user\u0022:{\u0022name\u0022:\u0022Ekstrom Bothman\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-10.jpg\u0022,\u0022initials\u0022:\u0022EB\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:34,\u0022startDate\u0022:\u002215 Nov, 2027\u0022,\u0022salary\u0022:\u0022$19,200\u0022},{\u0022id\u0022:11,\u0022user\u0022:{\u0022name\u0022:\u0022Sophia Martinez\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-11.jpg\u0022,\u0022initials\u0022:\u0022SM\u0022},\u0022position\u0022:\u0022Product Designer\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:29,\u0022startDate\u0022:\u002210 Jan, 2026\u0022,\u0022salary\u0022:\u0022$92,000\u0022},{\u0022id\u0022:12,\u0022user\u0022:{\u0022name\u0022:\u0022James Wilson\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-12.jpg\u0022,\u0022initials\u0022:\u0022JW\u0022},\u0022position\u0022:\u0022Software Engineer\u0022,\u0022office\u0022:\u0022Chicago\u0022,\u0022age\u0022:31,\u0022startDate\u0022:\u002214 Feb, 2026\u0022,\u0022salary\u0022:\u0022$115,000\u0022},{\u0022id\u0022:13,\u0022user\u0022:{\u0022name\u0022:\u0022Olivia Johnson\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-13.jpg\u0022,\u0022initials\u0022:\u0022OJ\u0022},\u0022position\u0022:\u0022Data Analyst\u0022,\u0022office\u0022:\u0022Los Angeles\u0022,\u0022age\u0022:28,\u0022startDate\u0022:\u002221 Mar, 2026\u0022,\u0022salary\u0022:\u0022$88,000\u0022},{\u0022id\u0022:14,\u0022user\u0022:{\u0022name\u0022:\u0022William Smith\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-14.jpg\u0022,\u0022initials\u0022:\u0022WS\u0022},\u0022position\u0022:\u0022Marketing Manager\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:41,\u0022startDate\u0022:\u002204 Apr, 2026\u0022,\u0022salary\u0022:\u0022$104,000\u0022},{\u0022id\u0022:15,\u0022user\u0022:{\u0022name\u0022:\u0022Isabella Davis\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-15.jpg\u0022,\u0022initials\u0022:\u0022ID\u0022},\u0022position\u0022:\u0022UI\\\/UX Designer\u0022,\u0022office\u0022:\u0022Austin\u0022,\u0022age\u0022:27,\u0022startDate\u0022:\u002218 May, 2026\u0022,\u0022salary\u0022:\u0022$96,000\u0022},{\u0022id\u0022:16,\u0022user\u0022:{\u0022name\u0022:\u0022Liam Moore\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-16.jpg\u0022,\u0022initials\u0022:\u0022LM\u0022},\u0022position\u0022:\u0022DevOps Engineer\u0022,\u0022office\u0022:\u0022Boston\u0022,\u0022age\u0022:35,\u0022startDate\u0022:\u002230 Jun, 2026\u0022,\u0022salary\u0022:\u0022$125,000\u0022},{\u0022id\u0022:17,\u0022user\u0022:{\u0022name\u0022:\u0022Mia Garcia\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022,\u0022initials\u0022:\u0022MG\u0022},\u0022position\u0022:\u0022Content Strategist\u0022,\u0022office\u0022:\u0022Denver\u0022,\u0022age\u0022:30,\u0022startDate\u0022:\u002212 Jul, 2026\u0022,\u0022salary\u0022:\u0022$74,000\u0022},{\u0022id\u0022:18,\u0022user\u0022:{\u0022name\u0022:\u0022Ethan Brown\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022,\u0022initials\u0022:\u0022EB\u0022},\u0022position\u0022:\u0022Solutions Architect\u0022,\u0022office\u0022:\u0022Seattle\u0022,\u0022age\u0022:44,\u0022startDate\u0022:\u002228 Aug, 2026\u0022,\u0022salary\u0022:\u0022$142,000\u0022},{\u0022id\u0022:19,\u0022user\u0022:{\u0022name\u0022:\u0022Charlotte Anderson\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-19.jpg\u0022,\u0022initials\u0022:\u0022CA\u0022},\u0022position\u0022:\u0022Product Manager\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:36,\u0022startDate\u0022:\u002216 Sep, 2026\u0022,\u0022salary\u0022:\u0022$130,000\u0022},{\u0022id\u0022:20,\u0022user\u0022:{\u0022name\u0022:\u0022Noah Taylor\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-20.jpg\u0022,\u0022initials\u0022:\u0022NT\u0022},\u0022position\u0022:\u0022Frontend Developer\u0022,\u0022office\u0022:\u0022Berlin\u0022,\u0022age\u0022:29,\u0022startDate\u0022:\u002202 Oct, 2026\u0022,\u0022salary\u0022:\u0022$85,000\u0022},{\u0022id\u0022:21,\u0022user\u0022:{\u0022name\u0022:\u0022Amelia Thomas\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-21.jpg\u0022,\u0022initials\u0022:\u0022AT\u0022},\u0022position\u0022:\u0022QA Engineer\u0022,\u0022office\u0022:\u0022Toronto\u0022,\u0022age\u0022:32,\u0022startDate\u0022:\u002219 Nov, 2026\u0022,\u0022salary\u0022:\u0022$79,000\u0022},{\u0022id\u0022:22,\u0022user\u0022:{\u0022name\u0022:\u0022Lucas White\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-22.jpg\u0022,\u0022initials\u0022:\u0022LW\u0022},\u0022position\u0022:\u0022Backend Developer\u0022,\u0022office\u0022:\u0022Chicago\u0022,\u0022age\u0022:33,\u0022startDate\u0022:\u002205 Dec, 2026\u0022,\u0022salary\u0022:\u0022$110,000\u0022},{\u0022id\u0022:23,\u0022user\u0022:{\u0022name\u0022:\u0022Harper Harris\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-23.jpg\u0022,\u0022initials\u0022:\u0022HH\u0022},\u0022position\u0022:\u0022Graphic Designer\u0022,\u0022office\u0022:\u0022Miami\u0022,\u0022age\u0022:25,\u0022startDate\u0022:\u002214 Jan, 2027\u0022,\u0022salary\u0022:\u0022$68,000\u0022},{\u0022id\u0022:24,\u0022user\u0022:{\u0022name\u0022:\u0022Mason Clark\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-24.jpg\u0022,\u0022initials\u0022:\u0022MC\u0022},\u0022position\u0022:\u0022System Administrator\u0022,\u0022office\u0022:\u0022Dallas\u0022,\u0022age\u0022:39,\u0022startDate\u0022:\u002222 Feb, 2027\u0022,\u0022salary\u0022:\u0022$94,000\u0022},{\u0022id\u0022:25,\u0022user\u0022:{\u0022name\u0022:\u0022Evelyn Lewis\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-25.jpg\u0022,\u0022initials\u0022:\u0022EL\u0022},\u0022position\u0022:\u0022HR Manager\u0022,\u0022office\u0022:\u0022Atlanta\u0022,\u0022age\u0022:42,\u0022startDate\u0022:\u002210 Mar, 2027\u0022,\u0022salary\u0022:\u0022$86,000\u0022},{\u0022id\u0022:26,\u0022user\u0022:{\u0022name\u0022:\u0022Alexander Robinson\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-26.jpg\u0022,\u0022initials\u0022:\u0022AR\u0022},\u0022position\u0022:\u0022Business Analyst\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:37,\u0022startDate\u0022:\u002201 Apr, 2027\u0022,\u0022salary\u0022:\u0022$98,000\u0022},{\u0022id\u0022:27,\u0022user\u0022:{\u0022name\u0022:\u0022Abigail Walker\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-27.jpg\u0022,\u0022initials\u0022:\u0022AW\u0022},\u0022position\u0022:\u0022Financial Planner\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:46,\u0022startDate\u0022:\u002217 May, 2027\u0022,\u0022salary\u0022:\u0022$112,000\u0022},{\u0022id\u0022:28,\u0022user\u0022:{\u0022name\u0022:\u0022Daniel Young\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-28.jpg\u0022,\u0022initials\u0022:\u0022DY\u0022},\u0022position\u0022:\u0022Operations Lead\u0022,\u0022office\u0022:\u0022Sydney\u0022,\u0022age\u0022:40,\u0022startDate\u0022:\u002225 Jun, 2027\u0022,\u0022salary\u0022:\u0022$108,000\u0022},{\u0022id\u0022:29,\u0022user\u0022:{\u0022name\u0022:\u0022Emily Hall\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-29.jpg\u0022,\u0022initials\u0022:\u0022EH\u0022},\u0022position\u0022:\u0022Project Coordinator\u0022,\u0022office\u0022:\u0022Dublin\u0022,\u0022age\u0022:28,\u0022startDate\u0022:\u002209 Jul, 2027\u0022,\u0022salary\u0022:\u0022$72,000\u0022},{\u0022id\u0022:30,\u0022user\u0022:{\u0022name\u0022:\u0022Matthew Allen\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-30.jpg\u0022,\u0022initials\u0022:\u0022MA\u0022},\u0022position\u0022:\u0022Security Analyst\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:34,\u0022startDate\u0022:\u002219 Aug, 2027\u0022,\u0022salary\u0022:\u0022$122,000\u0022},{\u0022id\u0022:31,\u0022user\u0022:{\u0022name\u0022:\u0022Elizabeth King\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-31.jpg\u0022,\u0022initials\u0022:\u0022EK\u0022},\u0022position\u0022:\u0022Database Admin\u0022,\u0022office\u0022:\u0022Tokyo\u0022,\u0022age\u0022:43,\u0022startDate\u0022:\u002203 Sep, 2027\u0022,\u0022salary\u0022:\u0022$105,000\u0022},{\u0022id\u0022:32,\u0022user\u0022:{\u0022name\u0022:\u0022Henry Wright\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-32.jpg\u0022,\u0022initials\u0022:\u0022HW\u0022},\u0022position\u0022:\u0022Scrum Master\u0022,\u0022office\u0022:\u0022Edinburgh\u0022,\u0022age\u0022:38,\u0022startDate\u0022:\u002229 Sep, 2027\u0022,\u0022salary\u0022:\u0022$95,000\u0022},{\u0022id\u0022:33,\u0022user\u0022:{\u0022name\u0022:\u0022Sofia Scott\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-33.jpg\u0022,\u0022initials\u0022:\u0022SS\u0022},\u0022position\u0022:\u0022Technical Writer\u0022,\u0022office\u0022:\u0022Vancouver\u0022,\u0022age\u0022:29,\u0022startDate\u0022:\u002215 Oct, 2027\u0022,\u0022salary\u0022:\u0022$76,000\u0022},{\u0022id\u0022:34,\u0022user\u0022:{\u0022name\u0022:\u0022Jackson Green\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-34.jpg\u0022,\u0022initials\u0022:\u0022JG\u0022},\u0022position\u0022:\u0022Cloud Consultant\u0022,\u0022office\u0022:\u0022Singapore\u0022,\u0022age\u0022:36,\u0022startDate\u0022:\u002202 Nov, 2027\u0022,\u0022salary\u0022:\u0022$134,000\u0022},{\u0022id\u0022:35,\u0022user\u0022:{\u0022name\u0022:\u0022Avery Adams\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-35.jpg\u0022,\u0022initials\u0022:\u0022AA\u0022},\u0022position\u0022:\u0022Customer Success Lead\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:31,\u0022startDate\u0022:\u002220 Nov, 2027\u0022,\u0022salary\u0022:\u0022$82,000\u0022},{\u0022id\u0022:36,\u0022user\u0022:{\u0022name\u0022:\u0022Sebastian Baker\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-36.jpg\u0022,\u0022initials\u0022:\u0022SB\u0022},\u0022position\u0022:\u0022Full Stack Engineer\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:32,\u0022startDate\u0022:\u002208 Dec, 2027\u0022,\u0022salary\u0022:\u0022$118,000\u0022},{\u0022id\u0022:37,\u0022user\u0022:{\u0022name\u0022:\u0022Chloe Gonzalez\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-37.jpg\u0022,\u0022initials\u0022:\u0022CG\u0022},\u0022position\u0022:\u0022UX Researcher\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:30,\u0022startDate\u0022:\u002222 Dec, 2027\u0022,\u0022salary\u0022:\u0022$91,000\u0022},{\u0022id\u0022:38,\u0022user\u0022:{\u0022name\u0022:\u0022Jack Nelson\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-01.jpg\u0022,\u0022initials\u0022:\u0022JN\u0022},\u0022position\u0022:\u0022Sales Representative\u0022,\u0022office\u0022:\u0022Austin\u0022,\u0022age\u0022:27,\u0022startDate\u0022:\u002205 Jan, 2028\u0022,\u0022salary\u0022:\u0022$65,000\u0022},{\u0022id\u0022:39,\u0022user\u0022:{\u0022name\u0022:\u0022Ella Carter\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-02.jpg\u0022,\u0022initials\u0022:\u0022EC\u0022},\u0022position\u0022:\u0022Legal Counsel\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:45,\u0022startDate\u0022:\u002218 Jan, 2028\u0022,\u0022salary\u0022:\u0022$145,000\u0022},{\u0022id\u0022:40,\u0022user\u0022:{\u0022name\u0022:\u0022Samuel Mitchell\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-03.jpg\u0022,\u0022initials\u0022:\u0022SM\u0022},\u0022position\u0022:\u0022Product Marketer\u0022,\u0022office\u0022:\u0022Boston\u0022,\u0022age\u0022:35,\u0022startDate\u0022:\u002203 Feb, 2028\u0022,\u0022salary\u0022:\u0022$96,000\u0022},{\u0022id\u0022:41,\u0022user\u0022:{\u0022name\u0022:\u0022Victoria Perez\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-04.jpg\u0022,\u0022initials\u0022:\u0022VP\u0022},\u0022position\u0022:\u0022Sales Manager\u0022,\u0022office\u0022:\u0022Chicago\u0022,\u0022age\u0022:41,\u0022startDate\u0022:\u002217 Feb, 2028\u0022,\u0022salary\u0022:\u0022$110,000\u0022},{\u0022id\u0022:42,\u0022user\u0022:{\u0022name\u0022:\u0022David Roberts\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-05.jpg\u0022,\u0022initials\u0022:\u0022DR\u0022},\u0022position\u0022:\u0022Software Architect\u0022,\u0022office\u0022:\u0022Seattle\u0022,\u0022age\u0022:47,\u0022startDate\u0022:\u002201 Mar, 2028\u0022,\u0022salary\u0022:\u0022$158,000\u0022},{\u0022id\u0022:43,\u0022user\u0022:{\u0022name\u0022:\u0022Grace Turner\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-06.jpg\u0022,\u0022initials\u0022:\u0022GT\u0022},\u0022position\u0022:\u0022Visual Designer\u0022,\u0022office\u0022:\u0022Miami\u0022,\u0022age\u0022:26,\u0022startDate\u0022:\u002215 Mar, 2028\u0022,\u0022salary\u0022:\u0022$71,000\u0022},{\u0022id\u0022:44,\u0022user\u0022:{\u0022name\u0022:\u0022Joseph Phillips\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-07.jpg\u0022,\u0022initials\u0022:\u0022JP\u0022},\u0022position\u0022:\u0022Security Engineer\u0022,\u0022office\u0022:\u0022Dallas\u0022,\u0022age\u0022:34,\u0022startDate\u0022:\u002228 Mar, 2028\u0022,\u0022salary\u0022:\u0022$128,000\u0022},{\u0022id\u0022:45,\u0022user\u0022:{\u0022name\u0022:\u0022Zoey Campbell\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-08.jpg\u0022,\u0022initials\u0022:\u0022ZC\u0022},\u0022position\u0022:\u0022Talent Acquisition\u0022,\u0022office\u0022:\u0022Denver\u0022,\u0022age\u0022:33,\u0022startDate\u0022:\u002211 Apr, 2028\u0022,\u0022salary\u0022:\u0022$78,000\u0022},{\u0022id\u0022:46,\u0022user\u0022:{\u0022name\u0022:\u0022Carter Parker\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-09.jpg\u0022,\u0022initials\u0022:\u0022CP\u0022},\u0022position\u0022:\u0022Network Engineer\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:38,\u0022startDate\u0022:\u002226 Apr, 2028\u0022,\u0022salary\u0022:\u0022$102,000\u0022},{\u0022id\u0022:47,\u0022user\u0022:{\u0022name\u0022:\u0022Penelope Evans\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-10.jpg\u0022,\u0022initials\u0022:\u0022PE\u0022},\u0022position\u0022:\u0022Brand Manager\u0022,\u0022office\u0022:\u0022Los Angeles\u0022,\u0022age\u0022:36,\u0022startDate\u0022:\u002209 May, 2028\u0022,\u0022salary\u0022:\u0022$97,000\u0022},{\u0022id\u0022:48,\u0022user\u0022:{\u0022name\u0022:\u0022Luke Edwards\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-11.jpg\u0022,\u0022initials\u0022:\u0022LE\u0022},\u0022position\u0022:\u0022Mobile Developer\u0022,\u0022office\u0022:\u0022Berlin\u0022,\u0022age\u0022:30,\u0022startDate\u0022:\u002224 May, 2028\u0022,\u0022salary\u0022:\u0022$90,000\u0022},{\u0022id\u0022:49,\u0022user\u0022:{\u0022name\u0022:\u0022Riley Collins\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-12.jpg\u0022,\u0022initials\u0022:\u0022RC\u0022},\u0022position\u0022:\u0022Financial Analyst\u0022,\u0022office\u0022:\u0022Tokyo\u0022,\u0022age\u0022:29,\u0022startDate\u0022:\u002207 Jun, 2028\u0022,\u0022salary\u0022:\u0022$87,000\u0022},{\u0022id\u0022:50,\u0022user\u0022:{\u0022name\u0022:\u0022Owen Stewart\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-13.jpg\u0022,\u0022initials\u0022:\u0022OS\u0022},\u0022position\u0022:\u0022Automation Tester\u0022,\u0022office\u0022:\u0022Toronto\u0022,\u0022age\u0022:31,\u0022startDate\u0022:\u002221 Jun, 2028\u0022,\u0022salary\u0022:\u0022$84,000\u0022},{\u0022id\u0022:51,\u0022user\u0022:{\u0022name\u0022:\u0022Nora Sanchez\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-14.jpg\u0022,\u0022initials\u0022:\u0022NS\u0022},\u0022position\u0022:\u0022Office Manager\u0022,\u0022office\u0022:\u0022Edinburgh\u0022,\u0022age\u0022:40,\u0022startDate\u0022:\u002208 Jul, 2028\u0022,\u0022salary\u0022:\u0022$68,000\u0022},{\u0022id\u0022:52,\u0022user\u0022:{\u0022name\u0022:\u0022Wyatt Morris\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-15.jpg\u0022,\u0022initials\u0022:\u0022WM\u0022},\u0022position\u0022:\u0022Support Specialist\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022age\u0022:27,\u0022startDate\u0022:\u002223 Jul, 2028\u0022,\u0022salary\u0022:\u0022$60,000\u0022},{\u0022id\u0022:53,\u0022user\u0022:{\u0022name\u0022:\u0022Lily Rogers\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-16.jpg\u0022,\u0022initials\u0022:\u0022LR\u0022},\u0022position\u0022:\u0022Marketing Specialist\u0022,\u0022office\u0022:\u0022Dublin\u0022,\u0022age\u0022:28,\u0022startDate\u0022:\u002205 Aug, 2028\u0022,\u0022salary\u0022:\u0022$73,000\u0022},{\u0022id\u0022:54,\u0022user\u0022:{\u0022name\u0022:\u0022Julian Reed\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022,\u0022initials\u0022:\u0022JR\u0022},\u0022position\u0022:\u0022Product Analyst\u0022,\u0022office\u0022:\u0022London\u0022,\u0022age\u0022:33,\u0022startDate\u0022:\u002219 Aug, 2028\u0022,\u0022salary\u0022:\u0022$89,000\u0022},{\u0022id\u0022:55,\u0022user\u0022:{\u0022name\u0022:\u0022Hannah Cook\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022,\u0022initials\u0022:\u0022HC\u0022},\u0022position\u0022:\u0022Billing Specialist\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022age\u0022:35,\u0022startDate\u0022:\u002202 Sep, 2028\u0022,\u0022salary\u0022:\u0022$70,000\u0022},{\u0022id\u0022:56,\u0022user\u0022:{\u0022name\u0022:\u0022Levi Morgan\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-19.jpg\u0022,\u0022initials\u0022:\u0022LM\u0022},\u0022position\u0022:\u0022Lead Architect\u0022,\u0022office\u0022:\u0022Austin\u0022,\u0022age\u0022:46,\u0022startDate\u0022:\u002218 Sep, 2028\u0022,\u0022salary\u0022:\u0022$165,000\u0022},{\u0022id\u0022:57,\u0022user\u0022:{\u0022name\u0022:\u0022Stella Bell\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-20.jpg\u0022,\u0022initials\u0022:\u0022SB\u0022},\u0022position\u0022:\u0022Executive Assistant\u0022,\u0022office\u0022:\u0022Chicago\u0022,\u0022age\u0022:37,\u0022startDate\u0022:\u002230 Sep, 2028\u0022,\u0022salary\u0022:\u0022$76,500\u0022}]}'))" class="group/card flex flex-col data-[size=sm]:p-4 w-full max-w-full min-w-0 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 sm:p-0 dark:border-gray-800 dark:bg-white/3"><!-- Table Top Controls -->
    <div class="flex flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
    <!-- Page Size Selector -->
    <div class="flex items-center gap-3">
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400"> Show </span>
        <div class="w-18.5 shrink-0">
            <div data-slot="select" data-ui-root x-data="uiSelect(JSON.parse('{\u0022value\u0022:\u002210\u0022,\u0022multiple\u0022:false}'))" class="contents" @change="if ($event.detail.value) setPageSize(Number($event.detail.value))"><button type="button" role="combobox" aria-haspopup="listbox" aria-expanded="false" data-slot="select-trigger" data-size="sm" data-state="closed"
    x-ref="trigger" x-bind:id="id + '-trigger'" x-bind:aria-expanded="open ? 'true' : 'false'" x-bind:data-state="state" x-bind:data-popup-open="open ? '' : null"
    x-bind:data-placeholder="label == null ? '' : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)"
    aria-label="Select entries per page" class="group/select-trigger flex min-w-0 items-center justify-between gap-2 border py-2.5 outline-hidden transition-all duration-200 select-none hover:bg-gray-50/50 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-invalid:border-red-500 data-invalid:ring-3 data-invalid:ring-red-500/20 data-popup-open:border-brand-300 data-popup-open:ring-3 data-popup-open:ring-brand-500/20 data-[size=default]:h-11 data-[size=default]:rounded-[10px] data-[size=lg]:h-12 data-[size=lg]:rounded-[10px] data-[size=lg]:py-3 data-[size=lg]:ps-4.5 data-[size=lg]:pe-3.5 data-[size=sm]:h-9 data-[size=sm]:rounded-lg data-[size=sm]:py-2 data-[size=sm]:ps-3.5 data-[size=sm]:pe-2.5 dark:hover:bg-gray-800/50 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:data-popup-open:border-brand-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 h-9 w-full rounded-lg border-gray-300 bg-white px-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:border-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:border-gray-600">
    <span data-slot="select-value" 
    class="flex flex-1 items-center gap-2 truncate text-start text-gray-800 group-data-placeholder/select-trigger:text-gray-400 dark:text-white/90 dark:group-data-placeholder/select-trigger:text-gray-500"
    x-text="label ?? ''"></span>
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 group-hover/select-trigger:text-gray-700 group-data-popup-open/select-trigger:rotate-180 dark:text-gray-400 dark:group-hover/select-trigger:text-gray-300">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="listbox" tabindex="-1" style="outline: none;" x-bind:id="id" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="start"
            data-slot="select-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:0}" x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-select-content-available-height) min-w-(--reka-select-trigger-width) origin-(--reka-select-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-18.5 rounded-lg p-1">
            <div class="flex flex-col gap-1 outline-none"><div role="option" tabindex="-1" data-slot="select-item" data-value="5"     x-init="register('5', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('5') ? 'true' : 'false'" x-bind:data-state="isSelected('5') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('5')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">5</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('5')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="10"     x-init="register('10', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('10') ? 'true' : 'false'" x-bind:data-state="isSelected('10') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('10')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">10</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('10')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="20"     x-init="register('20', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('20') ? 'true' : 'false'" x-bind:data-state="isSelected('20') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('20')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">20</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('20')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="50"     x-init="register('50', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('50') ? 'true' : 'false'" x-bind:data-state="isSelected('50') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('50')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">50</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('50')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div></div>
        </div>
    </div>
</template></div>
        </div>
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400"> entries </span>
    </div>

            <!-- Global Search Input -->
        <div class="w-full sm:w-64 md:w-72">
            <div data-slot="input-group" role="group"  class="group/input-group relative flex w-full min-w-0 items-center border bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-10 rounded-[10px] border-gray-300 dark:border-gray-700"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5 ps-3.5 pe-0"><svg class="size-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></div>
                <input type="text" data-slot="input-group-control" placeholder="Search..." x-model="searchQuery" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0 text-sm placeholder:text-gray-400 dark:placeholder:text-gray-500"></div>
        </div>
    </div>

    <!-- Table Content -->
    <div class="max-w-full overflow-x-auto">
        <div class="min-w-180 2xl:min-w-210">
            <table class="min-w-full">
                <thead class="border-y border-gray-200 bg-gray-50/75 dark:border-gray-800 dark:bg-gray-900/50">
                    <tr>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('user')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">User</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('user') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('user') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('position')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Position</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('position') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('position') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('office')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Office</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('office') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('office') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('age')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Age</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('age') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('age') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('startDate')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Start date</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('startDate') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('startDate') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('salary')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Salary</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('salary') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('salary') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="px-4 py-3 sm:px-6">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400"> Action </span>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr x-show="rows.length === 0" style="display: none;">
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="mb-3 flex size-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6 text-gray-800 dark:text-white/90">
    <path
      d="M12 21.072V11.029m0 0c-.23 0-.46-.053-.67-.159m.67.159c.23 0 .46-.053.671-.159m0 0a1.5 1.5 0 01-1.341 0m1.341 0l7.55-3.774M11.33 10.87L3.78 7.096m16.441 0a1.499 1.499 0 00-.592-.533L12.67 3.084a1.5 1.5 0 00-1.341 0L4.372 6.563c-.247.123-.45.309-.592.533m16.441 0a1.5 1.5 0 01.237.808v8.19a1.5 1.5 0 01-.83 1.341l-6.957 3.479a1.5 1.5 0 01-1.341 0l-6.958-3.479a1.5 1.5 0 01-.829-1.342V7.904c0-.292.085-.571.237-.808"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                    </div>
                                    <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">No entries found</h4>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search to find what you're looking for.</p>
                                </div>
                            </td>
                        </tr>
                    <template x-for="row in rows" :key="row.id">
                        <tr class="border-b border-gray-200 last:border-b-0 transition-colors hover:bg-gray-50/50 dark:border-gray-800 dark:hover:bg-white/2">
                            <!-- User Cell - Name only -->
                            <td class="border-e border-gray-200 px-4 py-3.5 sm:px-6 dark:border-gray-800">
                                <span class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="row.user.name"></span>
                            </td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.position"></span></td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.office"></span></td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.age"></span></td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.startDate"></span></td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.salary"></span></td>

                            <!-- Action Cell -->
                            <td class="px-4 py-3.5 text-start sm:px-6">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="text-gray-500 transition-colors hover:text-red-500 dark:text-gray-400 dark:hover:text-red-500" :aria-label="`Delete ${row.user.name}`" @click="handleDelete(row.id)">
                                        <svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg>
                                    </button>
                                    <button type="button" class="text-gray-500 transition-colors hover:text-gray-800 dark:text-gray-400 dark:hover:text-white" :aria-label="`Edit ${row.user.name}`">
                                        <svg class="size-5" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.091 3.532a2.25 2.25 0 00-3.182 0l-8.302 8.302c-.308.308-.52.7-.61 1.126l-.735 3.485a.75.75 0 00.888.889l3.485-.735a2.25 2.25 0 001.127-.611l8.301-8.302a2.25 2.25 0 000-3.182l-.972-.972zm-2.121 1.06a.75.75 0 011.06 0l.973.973a.75.75 0 010 1.06l-.899.899-2.033-2.033.899-.898zm-1.96 1.96l-6.342 6.342a.75.75 0 00-.203.376l-.498 2.358 2.358-.497a.75.75 0 00.376-.204l6.343-6.342-2.033-2.033z"
      fill="currentColor"
    />
  </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table Footer Pagination -->
    <div class="flex flex-col gap-4 border-t border-gray-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-gray-800">
    
    <div x-show="totalPages > 0" class="flex items-center gap-1.5 self-center sm:self-auto">
        <!-- Previous Button -->
        <button type="button" :disabled="pageIndex <= 0" class="flex size-10 items-center justify-center rounded-[10px] border border-gray-200 bg-white text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5" aria-label="Previous page" @click="goPage(pageIndex - 1)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
        </button>

        <!-- Numbered Page Buttons -->
        <div class="flex items-center gap-1.5">
            <template x-for="(item, index) in pages" :key="typeof item === 'number' ? item : `ellipsis-${index}`">
                <div>
                    <template x-if="typeof item === 'string'">
                        <span class="flex size-10 items-center justify-center text-sm font-medium text-gray-500 dark:text-gray-400">...</span>
                    </template>
                    <template x-if="typeof item === 'number'">
                        <button
                            type="button"
                            class="flex size-10 items-center justify-center rounded-[10px] text-sm font-medium transition-colors"
                            :class="currentPage === item ? 'bg-brand-500 text-white shadow-theme-xs' : 'border border-gray-200 bg-white text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5'"
                            :aria-current="currentPage === item ? 'page' : null"
                            @click="goPage(item - 1)"
                            x-text="item"
                        ></button>
                    </template>
                </div>
            </template>
        </div>

        <!-- Next Button -->
        <button type="button" :disabled="pageIndex >= totalPages - 1" class="flex size-10 items-center justify-center rounded-[10px] border border-gray-200 bg-white text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5" aria-label="Next page" @click="goPage(pageIndex + 1)">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
        </button>
    </div>

            <p class="self-center text-sm font-medium text-gray-500 sm:self-auto dark:text-gray-400">
            Showing <span x-text="startEntry"></span> to <span x-text="endEntry"></span> of <span x-text="totalEntries"></span> entries
        </p>
    </div></div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Data Table 3
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div data-slot="card" data-size="default" x-data="tanstackTable('table-three', JSON.parse('{\u0022rows\u0022:[{\u0022id\u0022:1,\u0022user\u0022:{\u0022name\u0022:\u0022Lindsey Curtis\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022salary\u0022:\u0022$168,500\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:2,\u0022user\u0022:{\u0022name\u0022:\u0022Kaiya George\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022},\u0022position\u0022:\u0022Chief Executive Officer\u0022,\u0022salary\u0022:\u0022$23,500\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:3,\u0022user\u0022:{\u0022name\u0022:\u0022Zain Geidt\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022},\u0022position\u0022:\u0022Junior Technical Author\u0022,\u0022salary\u0022:\u0022$12,500\u0022,\u0022office\u0022:\u0022Tokyo\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:4,\u0022user\u0022:{\u0022name\u0022:\u0022Abram Schleifer\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022},\u0022position\u0022:\u0022Software Engineer\u0022,\u0022salary\u0022:\u0022$89,500\u0022,\u0022office\u0022:\u0022Edinburgh\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:5,\u0022user\u0022:{\u0022name\u0022:\u0022Carla George\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022},\u0022position\u0022:\u0022Software Engineer\u0022,\u0022salary\u0022:\u0022$15,500\u0022,\u0022office\u0022:\u0022London\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:6,\u0022user\u0022:{\u0022name\u0022:\u0022Emery Culhane\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022},\u0022position\u0022:\u0022Integration Specialist\u0022,\u0022salary\u0022:\u0022$23,500\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:7,\u0022user\u0022:{\u0022name\u0022:\u0022Livia Donin\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022},\u0022position\u0022:\u0022Pre-Sales Support\u0022,\u0022salary\u0022:\u0022$58,500\u0022,\u0022office\u0022:\u0022London\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:8,\u0022user\u0022:{\u0022name\u0022:\u0022Miracle Bator\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022},\u0022position\u0022:\u0022Sales Assistant\u0022,\u0022salary\u0022:\u0022$34,900\u0022,\u0022office\u0022:\u0022Tokyo\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:9,\u0022user\u0022:{\u0022name\u0022:\u0022Lincoln Herwitz\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022},\u0022position\u0022:\u0022Software Engineer\u0022,\u0022salary\u0022:\u0022$18,300\u0022,\u0022office\u0022:\u0022London\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:10,\u0022user\u0022:{\u0022name\u0022:\u0022Ekstrom Bothman\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022},\u0022position\u0022:\u0022Senior Javascript Developer\u0022,\u0022salary\u0022:\u0022$19,200\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:11,\u0022user\u0022:{\u0022name\u0022:\u0022Sophia Martinez\u0022,\u0022email\u0022:\u0022sophia.m@gmail.com\u0022},\u0022position\u0022:\u0022Product Designer\u0022,\u0022salary\u0022:\u0022$92,000\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:12,\u0022user\u0022:{\u0022name\u0022:\u0022James Wilson\u0022,\u0022email\u0022:\u0022james.w@gmail.com\u0022},\u0022position\u0022:\u0022Software Engineer\u0022,\u0022salary\u0022:\u0022$115,000\u0022,\u0022office\u0022:\u0022Chicago\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:13,\u0022user\u0022:{\u0022name\u0022:\u0022Olivia Johnson\u0022,\u0022email\u0022:\u0022olivia.j@gmail.com\u0022},\u0022position\u0022:\u0022Data Analyst\u0022,\u0022salary\u0022:\u0022$88,000\u0022,\u0022office\u0022:\u0022Los Angeles\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:14,\u0022user\u0022:{\u0022name\u0022:\u0022William Smith\u0022,\u0022email\u0022:\u0022william.s@gmail.com\u0022},\u0022position\u0022:\u0022Marketing Manager\u0022,\u0022salary\u0022:\u0022$104,000\u0022,\u0022office\u0022:\u0022London\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:15,\u0022user\u0022:{\u0022name\u0022:\u0022Isabella Davis\u0022,\u0022email\u0022:\u0022isabella.d@gmail.com\u0022},\u0022position\u0022:\u0022UI\\\/UX Designer\u0022,\u0022salary\u0022:\u0022$96,000\u0022,\u0022office\u0022:\u0022Austin\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:16,\u0022user\u0022:{\u0022name\u0022:\u0022Liam Moore\u0022,\u0022email\u0022:\u0022liam.m@gmail.com\u0022},\u0022position\u0022:\u0022DevOps Engineer\u0022,\u0022salary\u0022:\u0022$125,000\u0022,\u0022office\u0022:\u0022Boston\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:17,\u0022user\u0022:{\u0022name\u0022:\u0022Mia Garcia\u0022,\u0022email\u0022:\u0022mia.g@gmail.com\u0022},\u0022position\u0022:\u0022Content Strategist\u0022,\u0022salary\u0022:\u0022$74,000\u0022,\u0022office\u0022:\u0022Denver\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:18,\u0022user\u0022:{\u0022name\u0022:\u0022Ethan Brown\u0022,\u0022email\u0022:\u0022ethan.b@gmail.com\u0022},\u0022position\u0022:\u0022Solutions Architect\u0022,\u0022salary\u0022:\u0022$142,000\u0022,\u0022office\u0022:\u0022Seattle\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:19,\u0022user\u0022:{\u0022name\u0022:\u0022Charlotte Anderson\u0022,\u0022email\u0022:\u0022charlotte.a@gmail.com\u0022},\u0022position\u0022:\u0022Product Manager\u0022,\u0022salary\u0022:\u0022$130,000\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:20,\u0022user\u0022:{\u0022name\u0022:\u0022Noah Taylor\u0022,\u0022email\u0022:\u0022noah.t@gmail.com\u0022},\u0022position\u0022:\u0022Frontend Developer\u0022,\u0022salary\u0022:\u0022$85,000\u0022,\u0022office\u0022:\u0022Berlin\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:21,\u0022user\u0022:{\u0022name\u0022:\u0022Amelia Thomas\u0022,\u0022email\u0022:\u0022amelia.t@gmail.com\u0022},\u0022position\u0022:\u0022QA Engineer\u0022,\u0022salary\u0022:\u0022$79,000\u0022,\u0022office\u0022:\u0022Toronto\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:22,\u0022user\u0022:{\u0022name\u0022:\u0022Lucas White\u0022,\u0022email\u0022:\u0022lucas.w@gmail.com\u0022},\u0022position\u0022:\u0022Backend Developer\u0022,\u0022salary\u0022:\u0022$110,000\u0022,\u0022office\u0022:\u0022Chicago\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:23,\u0022user\u0022:{\u0022name\u0022:\u0022Harper Harris\u0022,\u0022email\u0022:\u0022harper.h@gmail.com\u0022},\u0022position\u0022:\u0022Graphic Designer\u0022,\u0022salary\u0022:\u0022$68,000\u0022,\u0022office\u0022:\u0022Miami\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:24,\u0022user\u0022:{\u0022name\u0022:\u0022Mason Clark\u0022,\u0022email\u0022:\u0022mason.c@gmail.com\u0022},\u0022position\u0022:\u0022System Administrator\u0022,\u0022salary\u0022:\u0022$94,000\u0022,\u0022office\u0022:\u0022Dallas\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:25,\u0022user\u0022:{\u0022name\u0022:\u0022Evelyn Lewis\u0022,\u0022email\u0022:\u0022evelyn.l@gmail.com\u0022},\u0022position\u0022:\u0022HR Manager\u0022,\u0022salary\u0022:\u0022$86,000\u0022,\u0022office\u0022:\u0022Atlanta\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:26,\u0022user\u0022:{\u0022name\u0022:\u0022Alexander Robinson\u0022,\u0022email\u0022:\u0022alexander.r@gmail.com\u0022},\u0022position\u0022:\u0022Business Analyst\u0022,\u0022salary\u0022:\u0022$98,000\u0022,\u0022office\u0022:\u0022London\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:27,\u0022user\u0022:{\u0022name\u0022:\u0022Abigail Walker\u0022,\u0022email\u0022:\u0022abigail.w@gmail.com\u0022},\u0022position\u0022:\u0022Financial Planner\u0022,\u0022salary\u0022:\u0022$102,000\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:28,\u0022user\u0022:{\u0022name\u0022:\u0022Daniel Hall\u0022,\u0022email\u0022:\u0022daniel.h@gmail.com\u0022},\u0022position\u0022:\u0022Security Analyst\u0022,\u0022salary\u0022:\u0022$118,000\u0022,\u0022office\u0022:\u0022Washington\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:29,\u0022user\u0022:{\u0022name\u0022:\u0022Emily Allen\u0022,\u0022email\u0022:\u0022emily.a@gmail.com\u0022},\u0022position\u0022:\u0022Operations Specialist\u0022,\u0022salary\u0022:\u0022$76,000\u0022,\u0022office\u0022:\u0022Phoenix\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:30,\u0022user\u0022:{\u0022name\u0022:\u0022Matthew Young\u0022,\u0022email\u0022:\u0022matthew.y@gmail.com\u0022},\u0022position\u0022:\u0022Mobile App Developer\u0022,\u0022salary\u0022:\u0022$108,000\u0022,\u0022office\u0022:\u0022San Diego\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:31,\u0022user\u0022:{\u0022name\u0022:\u0022Ella King\u0022,\u0022email\u0022:\u0022ella.k@gmail.com\u0022},\u0022position\u0022:\u0022Copywriter\u0022,\u0022salary\u0022:\u0022$65,000\u0022,\u0022office\u0022:\u0022Portland\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:32,\u0022user\u0022:{\u0022name\u0022:\u0022Henry Wright\u0022,\u0022email\u0022:\u0022henry.w@gmail.com\u0022},\u0022position\u0022:\u0022Database Admin\u0022,\u0022salary\u0022:\u0022$112,000\u0022,\u0022office\u0022:\u0022Philadelphia\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:33,\u0022user\u0022:{\u0022name\u0022:\u0022Avery Scott\u0022,\u0022email\u0022:\u0022avery.s@gmail.com\u0022},\u0022position\u0022:\u0022Technical Writer\u0022,\u0022salary\u0022:\u0022$71,000\u0022,\u0022office\u0022:\u0022Minneapolis\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:34,\u0022user\u0022:{\u0022name\u0022:\u0022Jackson Green\u0022,\u0022email\u0022:\u0022jackson.g@gmail.com\u0022},\u0022position\u0022:\u0022Scrum Master\u0022,\u0022salary\u0022:\u0022$99,000\u0022,\u0022office\u0022:\u0022Salt Lake City\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:35,\u0022user\u0022:{\u0022name\u0022:\u0022Scarlett Adams\u0022,\u0022email\u0022:\u0022scarlett.a@gmail.com\u0022},\u0022position\u0022:\u0022Social Media Manager\u0022,\u0022salary\u0022:\u0022$67,000\u0022,\u0022office\u0022:\u0022Nashville\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:36,\u0022user\u0022:{\u0022name\u0022:\u0022Sebastian Baker\u0022,\u0022email\u0022:\u0022sebastian.b@gmail.com\u0022},\u0022position\u0022:\u0022Cloud Architect\u0022,\u0022salary\u0022:\u0022$145,000\u0022,\u0022office\u0022:\u0022Seattle\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:37,\u0022user\u0022:{\u0022name\u0022:\u0022Chloe Gonzalez\u0022,\u0022email\u0022:\u0022chloe.g@gmail.com\u0022},\u0022position\u0022:\u0022Legal Counsel\u0022,\u0022salary\u0022:\u0022$138,000\u0022,\u0022office\u0022:\u0022Boston\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:38,\u0022user\u0022:{\u0022name\u0022:\u0022Jack Nelson\u0022,\u0022email\u0022:\u0022jack.n@gmail.com\u0022},\u0022position\u0022:\u0022Customer Success Rep\u0022,\u0022salary\u0022:\u0022$62,000\u0022,\u0022office\u0022:\u0022Denver\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:39,\u0022user\u0022:{\u0022name\u0022:\u0022Grace Carter\u0022,\u0022email\u0022:\u0022grace.c@gmail.com\u0022},\u0022position\u0022:\u0022SEO Specialist\u0022,\u0022salary\u0022:\u0022$73,000\u0022,\u0022office\u0022:\u0022Tampa\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:40,\u0022user\u0022:{\u0022name\u0022:\u0022Owen Mitchell\u0022,\u0022email\u0022:\u0022owen.m@gmail.com\u0022},\u0022position\u0022:\u0022Network Engineer\u0022,\u0022salary\u0022:\u0022$95,000\u0022,\u0022office\u0022:\u0022Columbus\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:41,\u0022user\u0022:{\u0022name\u0022:\u0022Penelope Perez\u0022,\u0022email\u0022:\u0022penelope.p@gmail.com\u0022},\u0022position\u0022:\u0022Event Coordinator\u0022,\u0022salary\u0022:\u0022$59,000\u0022,\u0022office\u0022:\u0022Orlando\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:42,\u0022user\u0022:{\u0022name\u0022:\u0022Samuel Roberts\u0022,\u0022email\u0022:\u0022samuel.r@gmail.com\u0022},\u0022position\u0022:\u0022Full Stack Engineer\u0022,\u0022salary\u0022:\u0022$116,000\u0022,\u0022office\u0022:\u0022Raleigh\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:43,\u0022user\u0022:{\u0022name\u0022:\u0022Layla Turner\u0022,\u0022email\u0022:\u0022layla.t@gmail.com\u0022},\u0022position\u0022:\u0022PR Specialist\u0022,\u0022salary\u0022:\u0022$77,000\u0022,\u0022office\u0022:\u0022Charlotte\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:44,\u0022user\u0022:{\u0022name\u0022:\u0022David Phillips\u0022,\u0022email\u0022:\u0022david.p@gmail.com\u0022},\u0022position\u0022:\u0022Support Engineer\u0022,\u0022salary\u0022:\u0022$82,000\u0022,\u0022office\u0022:\u0022Indianapolis\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:45,\u0022user\u0022:{\u0022name\u0022:\u0022Riley Campbell\u0022,\u0022email\u0022:\u0022riley.c@gmail.com\u0022},\u0022position\u0022:\u0022Brand Strategist\u0022,\u0022salary\u0022:\u0022$89,000\u0022,\u0022office\u0022:\u0022Kansas City\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:46,\u0022user\u0022:{\u0022name\u0022:\u0022Joseph Parker\u0022,\u0022email\u0022:\u0022joseph.p@gmail.com\u0022},\u0022position\u0022:\u0022IT Director\u0022,\u0022salary\u0022:\u0022$155,000\u0022,\u0022office\u0022:\u0022San Jose\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:47,\u0022user\u0022:{\u0022name\u0022:\u0022Zoey Evans\u0022,\u0022email\u0022:\u0022zoey.e@gmail.com\u0022},\u0022position\u0022:\u0022Account Executive\u0022,\u0022salary\u0022:\u0022$91,000\u0022,\u0022office\u0022:\u0022Las Vegas\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:48,\u0022user\u0022:{\u0022name\u0022:\u0022Carter Edwards\u0022,\u0022email\u0022:\u0022carter.e@gmail.com\u0022},\u0022position\u0022:\u0022Product Marketing Mgr\u0022,\u0022salary\u0022:\u0022$106,000\u0022,\u0022office\u0022:\u0022Detroit\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:49,\u0022user\u0022:{\u0022name\u0022:\u0022Nora Collins\u0022,\u0022email\u0022:\u0022nora.c@gmail.com\u0022},\u0022position\u0022:\u0022UX Researcher\u0022,\u0022salary\u0022:\u0022$93,000\u0022,\u0022office\u0022:\u0022Pittsburgh\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:50,\u0022user\u0022:{\u0022name\u0022:\u0022Wyatt Stewart\u0022,\u0022email\u0022:\u0022wyatt.s@gmail.com\u0022},\u0022position\u0022:\u0022Site Reliability Eng\u0022,\u0022salary\u0022:\u0022$128,000\u0022,\u0022office\u0022:\u0022Sacramento\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:51,\u0022user\u0022:{\u0022name\u0022:\u0022Lily Sanchez\u0022,\u0022email\u0022:\u0022lily.s@gmail.com\u0022},\u0022position\u0022:\u0022Video Producer\u0022,\u0022salary\u0022:\u0022$70,000\u0022,\u0022office\u0022:\u0022Cleveland\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:52,\u0022user\u0022:{\u0022name\u0022:\u0022Julian Morris\u0022,\u0022email\u0022:\u0022julian.m@gmail.com\u0022},\u0022position\u0022:\u0022Compliance Officer\u0022,\u0022salary\u0022:\u0022$100,000\u0022,\u0022office\u0022:\u0022Cincinnati\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:53,\u0022user\u0022:{\u0022name\u0022:\u0022Hannah Rogers\u0022,\u0022email\u0022:\u0022hannah.r@gmail.com\u0022},\u0022position\u0022:\u0022Talent Recruiter\u0022,\u0022salary\u0022:\u0022$78,000\u0022,\u0022office\u0022:\u0022Baltimore\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:54,\u0022user\u0022:{\u0022name\u0022:\u0022Luke Reed\u0022,\u0022email\u0022:\u0022luke.r@gmail.com\u0022},\u0022position\u0022:\u0022Sales Engineer\u0022,\u0022salary\u0022:\u0022$114,000\u0022,\u0022office\u0022:\u0022Milwaukee\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:55,\u0022user\u0022:{\u0022name\u0022:\u0022Stella Cook\u0022,\u0022email\u0022:\u0022stella.c@gmail.com\u0022},\u0022position\u0022:\u0022Office Manager\u0022,\u0022salary\u0022:\u0022$61,000\u0022,\u0022office\u0022:\u0022St. Louis\u0022,\u0022status\u0022:\u0022In Progress\u0022},{\u0022id\u0022:56,\u0022user\u0022:{\u0022name\u0022:\u0022Gabriel Morgan\u0022,\u0022email\u0022:\u0022gabriel.m@gmail.com\u0022},\u0022position\u0022:\u0022AI Specialist\u0022,\u0022salary\u0022:\u0022$150,000\u0022,\u0022office\u0022:\u0022San Francisco\u0022,\u0022status\u0022:\u0022Hired\u0022},{\u0022id\u0022:57,\u0022user\u0022:{\u0022name\u0022:\u0022Violet Bell\u0022,\u0022email\u0022:\u0022violet.b@gmail.com\u0022},\u0022position\u0022:\u0022Growth Hacker\u0022,\u0022salary\u0022:\u0022$87,000\u0022,\u0022office\u0022:\u0022New York\u0022,\u0022status\u0022:\u0022Pending\u0022}]}'))" class="group/card flex flex-col data-[size=sm]:p-4 w-full max-w-full min-w-0 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 sm:p-0 dark:border-gray-800 dark:bg-white/3"><!-- Table Top Controls -->
    <div class="flex flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
    <!-- Page Size Selector -->
    <div class="flex items-center gap-3">
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400"> Show </span>
        <div class="w-18.5 shrink-0">
            <div data-slot="select" data-ui-root x-data="uiSelect(JSON.parse('{\u0022value\u0022:\u002210\u0022,\u0022multiple\u0022:false}'))" class="contents" @change="if ($event.detail.value) setPageSize(Number($event.detail.value))"><button type="button" role="combobox" aria-haspopup="listbox" aria-expanded="false" data-slot="select-trigger" data-size="sm" data-state="closed"
    x-ref="trigger" x-bind:id="id + '-trigger'" x-bind:aria-expanded="open ? 'true' : 'false'" x-bind:data-state="state" x-bind:data-popup-open="open ? '' : null"
    x-bind:data-placeholder="label == null ? '' : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)"
    aria-label="Select entries per page" class="group/select-trigger flex min-w-0 items-center justify-between gap-2 border py-2.5 outline-hidden transition-all duration-200 select-none hover:bg-gray-50/50 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-invalid:border-red-500 data-invalid:ring-3 data-invalid:ring-red-500/20 data-popup-open:border-brand-300 data-popup-open:ring-3 data-popup-open:ring-brand-500/20 data-[size=default]:h-11 data-[size=default]:rounded-[10px] data-[size=lg]:h-12 data-[size=lg]:rounded-[10px] data-[size=lg]:py-3 data-[size=lg]:ps-4.5 data-[size=lg]:pe-3.5 data-[size=sm]:h-9 data-[size=sm]:rounded-lg data-[size=sm]:py-2 data-[size=sm]:ps-3.5 data-[size=sm]:pe-2.5 dark:hover:bg-gray-800/50 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:data-popup-open:border-brand-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 h-9 w-full rounded-lg border-gray-300 bg-white px-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:border-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:border-gray-600">
    <span data-slot="select-value" 
    class="flex flex-1 items-center gap-2 truncate text-start text-gray-800 group-data-placeholder/select-trigger:text-gray-400 dark:text-white/90 dark:group-data-placeholder/select-trigger:text-gray-500"
    x-text="label ?? ''"></span>
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 group-hover/select-trigger:text-gray-700 group-data-popup-open/select-trigger:rotate-180 dark:text-gray-400 dark:group-hover/select-trigger:text-gray-300">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="listbox" tabindex="-1" style="outline: none;" x-bind:id="id" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="start"
            data-slot="select-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:0}" x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-select-content-available-height) min-w-(--reka-select-trigger-width) origin-(--reka-select-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-18.5 rounded-lg p-1">
            <div class="flex flex-col gap-1 outline-none"><div role="option" tabindex="-1" data-slot="select-item" data-value="5"     x-init="register('5', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('5') ? 'true' : 'false'" x-bind:data-state="isSelected('5') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('5')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">5</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('5')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="10"     x-init="register('10', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('10') ? 'true' : 'false'" x-bind:data-state="isSelected('10') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('10')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">10</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('10')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="20"     x-init="register('20', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('20') ? 'true' : 'false'" x-bind:data-state="isSelected('20') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('20')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">20</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('20')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="50"     x-init="register('50', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('50') ? 'true' : 'false'" x-bind:data-state="isSelected('50') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('50')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 py-1.5 ps-3 pe-8 text-sm">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">50</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('50')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div></div>
        </div>
    </div>
</template></div>
        </div>
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400"> entries </span>
    </div>

            <!-- Global Search Input & Download Button -->
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="w-full sm:w-64 md:w-72">
                <div data-slot="input-group" role="group"  class="group/input-group relative flex w-full min-w-0 items-center border bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-10 rounded-[10px] border-gray-300 dark:border-gray-700"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5 ps-3.5 pe-0"><svg class="size-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></div>
                    <input type="text" data-slot="input-group-control" placeholder="Search..." x-model="searchQuery" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0 text-sm placeholder:text-gray-400 dark:placeholder:text-gray-500"></div>
            </div>

            <button data-slot="button" type="button" @click="handleDownload([&#039;User&#039;, &#039;Email&#039;, &#039;Position&#039;, &#039;Salary&#039;, &#039;Office&#039;, &#039;Status&#039;], (c) =&gt; [c.user.name, c.user.email, c.position, c.salary, c.office, c.status], &#039;candidates_export.csv&#039;)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-transparent hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-2 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-10 rounded-[10px] border-gray-300 px-4 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/5"><span>Download</span>
                <svg class="size-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
    <path
      d="M15 12v1.875c0 .621-.503 1.125-1.125 1.125h-9.75A1.125 1.125 0 013 13.875V12M9 12V3m-3.47 5.532L9 11.998l3.468-3.466"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>
        </div>
    </div>

    <!-- Table Content -->
    <div class="max-w-full overflow-x-auto">
        <div class="min-w-225">
            <table class="min-w-full">
                <thead class="border-y border-gray-200 bg-gray-50/75 dark:border-gray-800 dark:bg-gray-900/50">
                    <tr>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <div class="flex items-center gap-3">
                                <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(isAllPageSelected) ? 'true' : 'false'"
    x-bind:data-state="Boolean(isAllPageSelected) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(isAllPageSelected) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(isAllPageSelected) })"
        aria-label="Select all rows" @change="handleSelectAll()" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(isAllPageSelected)"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
                                <button type="button" @click="toggleSorting('user')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">User</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('user') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('user') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                            </div>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('position')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Position</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('position') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('position') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('salary')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Salary</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('salary') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('salary') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('office')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Office</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('office') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('office') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="border-e border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-800">
                            <button type="button" @click="toggleSorting('status')" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Status</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('status') === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" x-bind:class="isSorted('status') === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'" class="size-2 transition-colors">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                        </th>
                        <th class="px-4 py-3 sm:px-6">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400"> Action </span>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr x-show="rows.length === 0" style="display: none;">
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="mb-3 flex size-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6 text-gray-800 dark:text-white/90">
    <path
      d="M12 21.072V11.029m0 0c-.23 0-.46-.053-.67-.159m.67.159c.23 0 .46-.053.671-.159m0 0a1.5 1.5 0 01-1.341 0m1.341 0l7.55-3.774M11.33 10.87L3.78 7.096m16.441 0a1.499 1.499 0 00-.592-.533L12.67 3.084a1.5 1.5 0 00-1.341 0L4.372 6.563c-.247.123-.45.309-.592.533m16.441 0a1.5 1.5 0 01.237.808v8.19a1.5 1.5 0 01-.83 1.341l-6.957 3.479a1.5 1.5 0 01-1.341 0l-6.958-3.479a1.5 1.5 0 01-.829-1.342V7.904c0-.292.085-.571.237-.808"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                    </div>
                                    <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">No entries found</h4>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search to find what you're looking for.</p>
                                </div>
                            </td>
                        </tr>
                    <template x-for="row in rows" :key="row.id">
                        <tr class="border-b border-gray-200 transition-colors last:border-b-0 dark:border-gray-800" :class="rowSelection[String(row.id)] ? 'bg-gray-50/75 dark:bg-white/4' : 'hover:bg-gray-50/50 dark:hover:bg-white/2'">
                            <!-- User Cell with Checkbox -->
                            <td class="border-e border-gray-200 px-4 py-3.5 sm:px-6 dark:border-gray-800">
                                <div class="flex items-center gap-3">
                                    <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(!!rowSelection[String(row.id)]) ? 'true' : 'false'"
    x-bind:data-state="Boolean(!!rowSelection[String(row.id)]) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(!!rowSelection[String(row.id)]) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(!!rowSelection[String(row.id)]) })"
        x-bind:aria-label="`Select ${row.user.name}`" @change="handleSelectRow(row.id)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(!!rowSelection[String(row.id)])"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
                                    <div class="flex flex-col text-start">
                                        <span class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="row.user.name"></span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400" x-text="row.user.email"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.position"></span></td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.salary"></span></td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="row.office"></span></td>
                            <td class="border-e border-gray-200 px-4 py-3.5 text-start sm:px-6 dark:border-gray-800">
                                <span data-slot="badge" x-bind:class="(JSON.parse('{\u0022Hired\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022In Progress\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500\\\/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)]\u0022,\u0022Pending\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500\\\/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]\u0022}'))[row.status] ?? (JSON.parse('{\u0022Hired\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022In Progress\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500\\\/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)]\u0022,\u0022Pending\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500\\\/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]\u0022}'))['In Progress']" x-text="row.status"></span>
                            </td>

                            <!-- Action Cell -->
                            <td class="px-4 py-3.5 sm:px-6">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="text-gray-500 transition-colors hover:text-red-500 dark:text-gray-400 dark:hover:text-red-500" :aria-label="`Delete ${row.user.name}`" @click="handleDelete(row.id)">
                                        <svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg>
                                    </button>
                                    <button type="button" class="text-gray-500 transition-colors hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90" :aria-label="`Edit ${row.user.name}`">
                                        <svg class="size-5" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.091 3.532a2.25 2.25 0 00-3.182 0l-8.302 8.302c-.308.308-.52.7-.61 1.126l-.735 3.485a.75.75 0 00.888.889l3.485-.735a2.25 2.25 0 001.127-.611l8.301-8.302a2.25 2.25 0 000-3.182l-.972-.972zm-2.121 1.06a.75.75 0 011.06 0l.973.973a.75.75 0 010 1.06l-.899.899-2.033-2.033.899-.898zm-1.96 1.96l-6.342 6.342a.75.75 0 00-.203.376l-.498 2.358 2.358-.497a.75.75 0 00.376-.204l6.343-6.342-2.033-2.033z"
      fill="currentColor"
    />
  </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table Footer Pagination -->
    <div class="flex flex-col gap-4 border-t border-gray-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-gray-800">
            <!-- Entries Info -->
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Showing <span x-text="startEntry"></span> to <span x-text="endEntry"></span> of <span x-text="totalEntries"></span> entries
        </p>
    
    <div x-show="totalPages > 0" class="flex items-center gap-1.5 self-center sm:self-auto">
        <!-- Previous Button -->
        <button type="button" :disabled="pageIndex <= 0" class="flex size-10 items-center justify-center rounded-[10px] border border-gray-200 bg-white text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5" aria-label="Previous page" @click="goPage(pageIndex - 1)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
        </button>

        <!-- Numbered Page Buttons -->
        <div class="flex items-center gap-1.5">
            <template x-for="(item, index) in pages" :key="typeof item === 'number' ? item : `ellipsis-${index}`">
                <div>
                    <template x-if="typeof item === 'string'">
                        <span class="flex size-10 items-center justify-center text-sm font-medium text-gray-500 dark:text-gray-400">...</span>
                    </template>
                    <template x-if="typeof item === 'number'">
                        <button
                            type="button"
                            class="flex size-10 items-center justify-center rounded-[10px] text-sm font-medium transition-colors"
                            :class="currentPage === item ? 'bg-brand-500 text-white shadow-theme-xs' : 'border border-gray-200 bg-white text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5'"
                            :aria-current="currentPage === item ? 'page' : null"
                            @click="goPage(item - 1)"
                            x-text="item"
                        ></button>
                    </template>
                </div>
            </template>
        </div>

        <!-- Next Button -->
        <button type="button" :disabled="pageIndex >= totalPages - 1" class="flex size-10 items-center justify-center rounded-[10px] border border-gray-200 bg-white text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5" aria-label="Next page" @click="goPage(pageIndex + 1)">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
        </button>
    </div>

    </div></div>
        </div>
    </div>
</div>    </div>
            </div>
        </div>

    </div>

</body>


</html>
