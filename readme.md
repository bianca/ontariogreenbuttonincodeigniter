# Ontario Green Button extension on Codeigniter OAuth 2.0 

This is a quick & dirty extension for Ontario's new Green Button API, meant to be added on top of (https://github.com/philsturgeon/codeigniter-oauth) [https://github.com/philsturgeon/codeigniter-oauth]

You should probably:

- toss your client id and secret into applications/config/greenbutton.php
- pop gb_custodians.sql into your mysql instance (or rewrite it for something else)
- navigate to yoursite/greenbutton/auth

## TODO

- Abstract out the Mysql
- better xml parsing
- handling more than just UsagePoint.... There's no subscription stuff yet

Contribute
----------

1. Go ahead and submit changes to this branch. It needs a lot of help!

[the repository]: https://github.com/bianca/ontariogreenbuttonincodeigniter