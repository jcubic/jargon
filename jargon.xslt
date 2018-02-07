<?xml version="1.0" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output
       method="xml"
       indent="yes"
       encoding="iso-8859-1" />

    <xsl:template match="part">
        <xsl:if test="@id = 'lexicon'">
            <xsl:apply-templates select="glossary"/>
        </xsl:if>
    </xsl:template>
    <xsl:template match="glossterm">
        <a href="#" rel="jargon"><xsl:value-of select="."/></a>
    </xsl:template>
    <xsl:template match="quote">
        <blockquote><xsl:value-of select="."/></blockquote>
    </xsl:template>
    <xsl:template match="emphasis">
        <strong><xsl:value-of select="."/></strong>
    </xsl:template>
    <xsl:template match="ulink">
        <a href="{.}"><xsl:value-of select="."/></a>
    </xsl:template>
	<xsl:template match="glossary">
        <ul>
        <xsl:for-each select="*/glossentry">
            <li>
                <h2><xsl:value-of select="glossterm"/> 
                    <xsl:if test="abbrev">
                      <xsl:text>: </xsl:text>
                      <xsl:for-each select="abbrev/*">
                        <xsl:if test="position() &gt; 1">, </xsl:if>
                        <xsl:apply-templates select="."/>
                      </xsl:for-each>
                    </xsl:if>
                </h2>
                <div><xsl:apply-templates select="*/para"/></div>
            </li>
        </xsl:for-each>
        </ul>
    </xsl:template>
    <xsl:template match="book">
        <html>
            <title><xsl:value-of select="title"/></title>
        <body>
        <xsl:apply-templates select="part"/>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
