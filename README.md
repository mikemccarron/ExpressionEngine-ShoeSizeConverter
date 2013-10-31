ExpressionEngine: Shoe Size Converter
===================

ExpressionEngine 2.x plugin that convert US shoe sizes to other countries.

**USAGE**:

Pass the shoe size parameter in *US/Canada*, gender and the target country. This plugin will return the size equivlent for that country.

    {exp:shoe_size_converter gender='women' country='europe'}8{/exp:shoe_size_converter}

This will return "_38.5_";

**Acceptable Values**

*Gender*: men, women, child
*Countries*: usa, uk, china, australia, europe, mexico, japan