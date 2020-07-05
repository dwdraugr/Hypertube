<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('first_name')->nullable(true);
            $table->string('last_name')->nullable(true);
            $table->string('locale', 10)->default('en');
            $table->longText('icon')->default('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAACwVBMVEUAAAAAAAAAf39VVVU/Pz8zM2YqVVUkSG0kSEg/P184VFQ4OFQzTGYuRVwuRUUqP1U2SFszRGYvT18tS1o4RmMqOFQzTFkwSGEwPFQ3TVgsQk01Sl8yR1sxRGI4S142SFszTF02RVw0S2ExRlwzRl8xSl01R140S1wySWAxSF42Rlw1Sl80SF0yS181SV00SGA1R100SlwzSF0yR1stPU4sPFAzR18ySl4rPk4ySVw1SF80R10ySF4rPVAyR10sPk8ySV00SFwrPk8sPE80R10qPE4zSF0zR14ySV00SF40Sl0zSV4ySF01R1wsP040SF0zSFwySV4tPlAzSV0ySF40SVwzSF0sPlEqPE4ySV0zSF4vQlU0SV40SV4zSF0zR14rPVAySV0sPU80SF00SF4wQlYzSV0zSV4rPlA0SV0sPk80SV4zSF00SV40SV0yRl0zSV4sPk8zSV00SF40SV0zSF0sPE8xRls0SV40SF0zSF4zSV40SV0xSV0xR180SVwzR140SF0sPlAySV4zSF0rPVAzSV40R10ySF4sPVAzSVwqPk4zSV00SF40SV0ySV4zSF00SV4ySF0zSVw0SF4ySV00SV00SV4yR1wzSF00SV40R14ySV4zR1w0SV40SV40R1wySF4zSV40SV00SVwySV00SV4yR1wsPk40R10qPFAySVwySV4yR14zSF00SV40SVwySV40R14sPU4qPE4zR1w0SV4yR1w0SV40SVwqPk40R14ySV4ySVw0R14qPlAqPFA0SV0ySV4yR1w0SV4sPE40SV40SF4xR1wyR14ySVw0SVw0R140SVwySV4yR14qPE40R1wsPk40SV4sPlA0SV40SF0zSF0zSFwzR1syR1syRlsyRloxRVgwRVkwQ1cwQ1YvQlYvQlUuQFItQFItP1ItP1EsP1EsP1AsPlEsPlC5fKbDAAAA1XRSTlMAAQIDBAUGBwcICQkKCwsMDg8QERISFBUVFxcYGRobHB4hIiQoKSssLS4vMDEzNDU5Ojw9Pj9AQUFCQ0RGRkdKTE1NUFJUVVlaXF1eX2BhYmNkZmhpa21ucXN3d3l6e3x8fX1+f3+AgYKDg4SFh4iJioqLjY6QkJGSk5SVlpaWmJqbnJ2enp+hoqKjo6SlpqepqqyusLG0tba3uL3AwcLDxMXGx8nKzc/Q0tLU2Nna29ze4ODj5Obn6erq6+zt7u7v8PHy8/P09PX29/j5+vv8/P39/v6lJvO2AAADV0lEQVR4Ae3B+3/VcxwH8Nf3TDFZ7YKilaikWkxu3V02ZoWZLKaR61wWFdHobtFcuiDFonu53y8r5ZZcajpZx8vmrjSXz1/hFz952D6X837vp+/ziVgsFoulIcovHFNcPKawd4TO13XU1PU7+a+d62pGdkVnKnhgB/9je+0QdJYzGvi/njkdnaHvE2zX0nyom7CLHfisBLoyF9FiweFQlPM8rVZnQ83RL9DBllwoOWoDnaw5EiqiFXS0PIKGSjqrgIKCJJ19PQjiEpvoYU0EaeX0UgphXd6ml9czIOsSeiqBrE30tBaiBtDbSZBUTW9VkLSO3lZDUFaS3poyIaeQAYZBzqUMUAI5UxngJsiZwwD3Qk49A9RBznIGWAI5ixhgPuTUMsDdkFPFAJWQU8wA50HOQAboDzmJHfTWGEHQk/S2BJLK6K0UknL20NMXWRC1lJ4WQ9YwehoMYQ30sgLSCprpIXkyxNXSw3TIy3mLzl7rAQWn7qWjpiFQUU5HE6DkBjq5BlqiGjq4OYKeSSlaNE+EqtFb2aHGs6Es/2l24KnjoK7v3K/Yji/v7wNleRXrU+xAau2VudAzdPEeWu1+eDB0DH+WjlYWQt6gBnpYNRCy8ubvo5fk7BwIKm6kt/fOh5TsZQxSnwURBW8w0KunQMDFTQy2+yKkrZrpSF2L9CQWMk2zI6Qho55pW5hAsOhRCqhDsJkUcScCVVLIJAQZ10whyXMQ4MQPKWZ7P3g7bDMFbciAr1sp6jp4Om0fRe0dCi+JLRS2MYKPCoq7HB5yP6K4bT3groYKpsBZz11U8GkeXN1OFVPgKHMbVbzfBW7KqKQUbjZSyXNw0p9aUv3goppqquDiJarZDAcnUE+qJ+zKqWg87B6nojrYvUlFr8DqWGpqzobNKKoaDpuJVFUGm3uo6i7YLKOqetjUUdU82MyiqmmwuYWqJsPmtlYqar0eNo8doKKDD8HmEfMD1fz414OwucO0tVBJS5u5ETYXGHOolSpafzdmLGy6fW7Mn79Qwc9/G/PJEbC6zxhj2n77voWCvvvp1z+MMWYG7Hp9bNR8cAwcFH1rlOw/F06u2G9UfHMZHI191yh4ZwScdb/6ZSPsxau6wcvxZxVdKKbozF6IxWKxWDv+AZPo+kF7GkmIAAAAAElFTkSuQmCC');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
