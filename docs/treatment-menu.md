---
layout: post
permalink: treatment-menu
title: תפריט טיפולים
---

{% assign odeven_treat = 'odd' %}

<div  class="treatments-menu-t" >

{% for treatment in site.treatments %}
     <div class='treatment-tr-wrap'>
        <div class="treatment-tr-anchor" id="{{ treatment.name }}"></div>
        <div class='treatment-tr  treatment-t-name {{odeven_treat}}'>
        <div class='treatment-td'>
           <a class="treatment item grow" href="{{treatment.permalink}}" title="{{treatment.title}}">
                {{ treatment.title }}
            </a>
        </div>
        </div>
        <div class='treatment-tr  treatment-t-desc {{odeven_treat}}'>
            <div class='treatment-td'> {{ treatment.description }}</div>
        </div>
        <div class='treatment-tr  treatment-t-details {{odeven_treat}}'>
            <div class='treatment-td treatment-timing'>משך הטיפול: <strong>{{ treatment.time }} דקות </strong></div>
        </div>
     </div>

    {% if odeven_treat == 'odd' %}
        {% assign odeven_treat = 'even' %}
    {% else %}
        {% assign odeven_treat = 'odd' %}
    {% endif %}

{% endfor %}

</div>

{% include phone-contact.html %}