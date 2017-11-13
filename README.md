# fcs

One of the earliest PHP projects I worked on.  FCS is short for Friend Code Search.  The last write dates on my filesystem say December 20th 2012, but I know for a fact that I last actively worked on this longer ago than that - I'd guess somewhere around 2007.  I tried to preserve the project as much as possible - the only files I have modified were the hard-coded username/passwords for the database (hallmarks of great programming, surely).

The idea behind the project being a repository of the various friend codes that you would receive playing online games using the Nintendo DS and Nintendo Wii.  Instead of having a single username or code, Nintendo decided that each game gets its own friend code - which leaves a player with potentially 10 or more friend codes to manage.  The FCS would store these codes by user (with user data coming from a phpBB forum) and allow for searching by game or user.

There were even extra features like setting profile notes and whether or not you still played a game.  Back in its time having AJAX support was a pretty big deal and this project was my first foray into supporting that.  Back in the days before jQuery...

I also created an administrator area for adding (but only adding - no editing or removing) games to the system.  There were very strict image requirements, and if the image for the game was slighly off - the whole thing errored out and stopped working.  It was generally very fragile.

Note my revolutionary use of versioning - old files were renamed with the extension `.ext~`, with each older version having more `~`s attached.