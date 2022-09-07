# typemill-link

> A Typemill link with parameters shortcode

## Use

Markdown

```
[:link text="Google" target="_blank" url="https://google.com.br/":]
[:link text="Google" url="https://google.com.br/":]
[:link text="Google":]
```


Output

```html
<a href="https://google.com.br/" target="_blank">Google</a>
<a href="https://google.com.br/">Google</a>
<a href="#">Google</a>
```
