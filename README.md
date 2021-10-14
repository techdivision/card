# Welcome to the Card family!
<img width="50" src="https://github.com/techdivision/card-documentation-assets/raw/master/assets/Logo.png" alt="" />

Available Card Packages  
[Card - the basics](https://github.com/techdivision/card)  
[Card decks - aggregate cards beautifully](https://github.com/techdivision/card-decks)      
[Card shuffle - deck filtering](https://github.com/techdivision/card-shuffle)      
[Bootstrap 4 styling for cards](https://github.com/techdivision/card-bootstrap4)        
[Materialize styling for cards](https://github.com/techdivision/card-materialize)  

# TechDivision.Card - Cards for structuring information
> Use this package if you
> - only want the very basic card features
> - know how to apply css classes and styling on your own  

Cards are one of the primary means of structuring information on a website clearly, distinctly and mobile-friendly.
They actually are the modern way of what has been called "teaser", "box" et al. in the past.
This package integrates cards into neos in a way that is easy to use and splitted into some packages, so that you only have to install what you need.

![Card examples](https://github.com/techdivision/card-documentation-assets/raw/master/assets/card/TechDivisionCard.png)

### Resources:
https://material.io/components/cards  
https://materializecss.com/cards.html

## For editors
When installed, TechDivision.Card comes with two new NodeTypes - and a new editing mode.

### Content Cards
Content Cards are plain content NodeTypes. They are not for reuse but have a card look and feel.
It can be used e.g. to show different product features.  
![Content Card example](https://github.com/techdivision/card-documentation-assets/raw/master/assets/card/ContentCard.gif)


### Document Cards
Document Cards are basically references to other pages and are highly reusable.  
You cannot edit information here, but in the document itself.  
This can be easily used to improve in-site-navigation by putting together document cards 
that introduce your products and link to them on different places within your website - 
but keep your data centralized.  
![Document Card example](https://github.com/techdivision/card-documentation-assets/raw/master/assets/card/DocumentCard.gif)

### Social Cards
Social Cards are links to other websites that carry either [opengraph](https://ogp.me/) or [twittercard](https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/abouts-cards) meta information.  
The card will display an image, title and description and link over to the page.  
We do not set target _blank, but we do add a [noopener attribute](https://developers.google.com/web/tools/lighthouse/audits/noopener) if you plan to add a target yourself.  
You can easily use this to link to newspapers, github or other pages connected with your website.  
![Social Card example](https://github.com/techdivision/card-documentation-assets/raw/master/assets/card/SocialCard.gif)


### Card Mode
In order to edit your cards, there is a new editing mode where you can preview your document card
in different sizes.  
![Card editing mode](https://github.com/techdivision/card-documentation-assets/raw/master/assets/card/CardMode.gif)

## For Developers

### Installation

TechDivision.Card is available via packagist. Add `"techdivision/card" : "~1.0"` to the require section of the composer.json
or run `composer require techdivision/card`.  
**This only installs the very basic card features. If you dont know what you do, we recommend using one of the other card packages instead.**

### Configuration
There is not much to configure, as TechDivision.Card runs out of the box. A few options are:

### NodeTypes Diagramm
This is an overview over the NodeTypes and how they work together:
![NodeTypes Diagramm](https://github.com/techdivision/card-documentation-assets/raw/master/assets/card/NodeTypeDiagramm.jpg)

#### Adding/Removing the CardMixin
By default, we add the Mixin to `Neos.NodeTypes:Page` - so that you can start working.  
If you do not want this behavior, use the following code:  
```
Neos.NodeTypes:Page:
  superTypes:
    'TechDivision.Card:CardMixin': false
```

If you have your own Document NodeType, add the Mixin as follows:

```
Your.Awesome.Package:SpecialDocumentNode:
  superTypes:
    'TechDivision.Card:CardMixin': true
    'TechDivision.Card:Constraint.Card.Document': true
```
The NodeType `TechDivision.Card:Constraint.Card.Document` is used for references and other constraints.

#### Add your own CardMode stylesheets
The CardMode contains very basic styling.
Feel free to add your own:

```
prototype(TechDivision.Card:CardModePage) {
    head.stylesheets.cardModeStylesheet.stylesheet.path = 'resource://Your.Awesome.Package/Public/Styles/CardMode.css'
}
```


### Develop your own styles
We added a set of afx-augmenters that you can use to easily change card styles.  
Best practice is to create your own package that overrides styles and components as you need.  
Put your `techdivision/card*` dependencies into that package's composer.json.  

[Look here to see an example](https://github.com/techdivision/card-materialize)

### Contribution
We will be happy to receive pull requests - dont hesitate!
