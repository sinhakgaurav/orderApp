#Application will be accessible on http://localhost:8080

#By default it will behave as a get request handler irrespective of the http request method and will show the list of top 10 orders.

#All configuration related files under /config folder.
- Google Access token : API_KEY_GOOGLE is created in constants file in config folder.

#Implemented Token based API authorization.

#Routing paths are written in routes api.php along with before call middleware class implementation that checks the api header token authorization.
    
#**.env file** under at root of code folder having:
- DB Authentication details

#Token is required to be placed in header of the request 
