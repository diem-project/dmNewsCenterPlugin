dmNewsLetterPlugin is a news management system for Diem CMF/CMS
Copyright (C) 2010 4levels / Thomas Ohms <http://www.lokarabia.de>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

## Differences with lrNewsPlugin
- Article and Newsletter is many-to-many related
- Category and Newsletter is many-to-many related
- Subscriber and Newsletter is many-to-many related
- Article has DmBlameable and DmGallery behaviour in favor of Author and Image relation

## TODOS
- Article archive
- Configurable DmTaggable behaviour for Articles
- Configurable NestedSet behaviour for Categories

## Templates
There are 2 mail templates used in this plugin:

*'confirm_newsletter_subscription' with the following variables:*
> - %firstname% => firstname of the subscriber
> - %lastname% => lastname of the subscriber
> - %email% => email address of the subscriber
> - %confirm_parameter% => the parameter for confirmation link (See 3. Parameters' for more details.)
> - %confirm_limit% => hours a subscription must be confirmed before subscriber gets deleted from database

*'newsletter' with the following variables:*
> - %firstname%, %lastname%, %email% => same as above
> - %edit_parameter% => the parameter for editing a subscription already in database (See '3. Parameters' for more details.)
> - %unsubscribe_parameter% => the parameter for removing a subscription from database (See '3. Parameters' for more details.)
> - %content_text% => all articles with title and summary relating to the current newsletter and generated absolute url as text
> - %content_html% => articles HTML formatted and with clickable, translated "Read more" link

## Parameters
Parameters give you the flexibility to choose an URL yourself. They will always just return the
method to use as URL variable and the subscriber's id as its value.
So for instance the %edit_parameter% returns: `?edit=3` for editing a subscriber with id 3.
You have to set the beginning of the URL yourself. So let's say you have the subscriber form under
http://mydomain.com/news/subscriber than you would have to insert into the template:
http://mydomain.com/news/subscriber%edit_parameter%

## Available modules
There are 4 widgets you can use in frontend:
- Articles List => Shows a list of all articles with summary, date and author
- Articles List Side => Shows a list of articles with titles only
- Articles Show => Shows a single article with its content/body
- Subscribers Subscription => Shows either the form for adding a new subscriber or editing an existing one


## Configuration

You can set in app.yml the following variables under news:

- maxFeedItems => How many items should be shown in the feed (default: 20)
- feedAuthor => Author that should be used for the whole feed (default: dmNewsLetterPlugin)
- showAuthor => Should the Author be shown on articles (default: false)
- wait4ConfirmationHours => Hours to wait until a new subscription has to be confirmed (default: 48)


## Feed
You can get the feed by calling i.e. http://yoursite.com/index.php/news/feed
By default the feed is cached. If you don't want it to be cached (not recommended) put inside your app's cache.yml:
> feed: 
>   cache: false 

## Usage
First you have to create a new newsletter and set a subject. You should use a name other than just 'Newsletter' so that you know inside of an article which newsletter your are choosing. So a better name would be 'Newsletter from 01.01.2010'.

Than you can either start directly adding a new article from within the newsletter's configuration form or if you have already an article which you like to integrate into the newsletter just go directly to that one and open it's edit form.

Inside the edit form on the right side there is a dropdown box where you can select the newsletter.

Than if you have all articles you want inside the newsletter go back to the newsletter list and click `Send` left of the newsletter subject. A page opens, showing you the title of the newsletter, the amount of subscribers it was send to and the titles of all articles that have been included.

If you set the mail template for newsletter to text than use variable %content_text% and for HTML mails use %content_html%

## Hint
If you want an article to be send in the newsletter, but not shown on the frontend just leave the article
inactive.