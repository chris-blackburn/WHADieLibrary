# WHA Die Library
This is what I created during my summer internship at Worth Higgins & Associates.

## Why?
In printing, there is something called a *die*. Dies are used to cut, perforate, and fold paper in unconventional ways.
Originally, information about these dies were being kept in an excel spreadsheet that was accessed via samba share.
A couple weeks into my internship, we discovered that windows users were no longer able to access the share - we
were left puzzled and were unable to find a solution. Instead of just moving the share to another computer, I suggested 
we make a web portal to access the library. This would solve the access issue and would also save money (that way we 
wouldn't have to buy tons of licenses for Microsoft Office just to access one spreadsheet). This is the result of my 
work.

## To-do
- [ ] add login function, use Database()->connect($user, $pass)

### Special Thanks
@christianbach for his awesome client side table sorting javascript magic. Check out his work [here](http://tablesorter.com).
