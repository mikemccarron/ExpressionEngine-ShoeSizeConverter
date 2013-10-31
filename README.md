ExpressionEngine: Shoe Size Converter
===================

ExpressionEngine 2.x plugin that convert US shoe sizes to other countries.

**USAGE**:

Wrap a standard numberic US/Canadian shoe size with the *exp:shoe_size_converter* plugin.
Pass *exp:shoe_size_converter* two parameters, **gender** and **country**.

    {exp:shoe_size_converter gender='women' country='europe'}8{/exp:shoe_size_converter}

The above example will return the European woman equvilant for size 8 which is "_38.5_";

**Acceptable Values**

*Gender*: men, women, child

*Countries*: usa, uk, china, australia, europe, mexico, japan