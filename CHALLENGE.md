# Challenge

- `git clone` the repository `https://github.com/thiago-clubforce/be-1-cqrs`
- Set up the project following README.md
- implement the Features #1, #2, #3
- commit to a private repository
- allow thiago@clubforce.com to access your repository

## Feature #1
Modify the endpoint `http://localhost:8080/posts` to accept the property `description`, it should accept and process the following request:
```
curl --location --request POST 'http://localhost:8080/posts' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
"title": "My first post",
"summary": "Nam non est risus. Donec at orci at lectus consequat scelerisque vel ac justo.",
"description": "Aliquam erat volutpat. Fusce ut porta quam, eget pulvinar lectus. Vivamus et sapien libero. Morbi ullamcorper congue diam, ac dapibus tellus dignissim eu."
}'
```
The new property must be saved into the database

## Feature #2

Modify the endpoint `http://localhost:8080/posts` to return a status 400 if the property `title` starts with `Qwerty`

## Feature #3

Implement the endpoint `http://localhost:8080/posts/{{post_id}}` to allow the request
```
curl --location --request GET 'http://localhost:8080/posts/{{post_id}}' \
--header 'Accept: application/json'
```

If post with `{{post_id}}` exists, it should return http status 200 and the following content:
```
{
    "post_id": "{{post_id}}",
    "title": "My first post",
    "summary": "Nam non est risus. Donec at orci at lectus consequat scelerisque vel ac justo."
}
```
If post does not exist, it should return http status 404 with empty response
