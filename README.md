# typemill-link

> A Typemill shortcode link with parameters

## Use

Markdown

```
[:link text="Google" id="link-google" class="my-custom-class" target="_blank" url="https://google.com.br/":]
[:link text="Google" id="link-google" target="_blank" url="https://google.com.br/":]
[:link text="Google" target="_blank" url="https://google.com.br/":]
[:link text="Google" url="https://google.com.br/":]
[:link text="Google":]
```

Output

```html
<a id="link-google" class="my-custom-class external" href="https://google.com.br/" target="_blank">Google</a>
<a id="link-google" class="external" href="https://google.com.br/" target="_blank">Google</a>
<a class="external" href="https://google.com.br/" target="_blank">Google</a>
<a href="https://google.com.br/" target="_self">Google</a>
<a href="#" target="_self">Google</a>
```
