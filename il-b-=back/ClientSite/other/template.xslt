<xsl:stylesheet version="2.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:variable name="tmp" select="'view1'" />
	
	<xsl:template match="/">
		<div>  Articles (<xsl:value-of select="$tmp"/>) </div>
		
        <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="500" >
				
					<xsl:apply-templates  select="//articel_detail" mode="$tmp" />
					
					
		</TABLE>
  </xsl:template>
  
  <xsl:template match="articel_detail" mode="view1">
		<TR><TH class="newsHeader">{View1}<xsl:value-of select="art_headline"/></TH></TR>
		<TR>
			<TD class="news"><xsl:value-of select="art_summary"/>
				<xsl:if test="art_img_src">
					<img width='150'>
					<xsl:attribute name="src"><xsl:value-of select="art_img_src"/></xsl:attribute>
					</img>
				</xsl:if>
			</TD>
		</TR>
		<TR><TD class="spacer"><xsl:value-of select="' '"/></TD></TR>
  </xsl:template>
  
  
  <xsl:template match="articel_detail" mode="view2">
		<TR><TH class="newsHeader">{View2}<xsl:value-of select="art_headline"/></TH></TR>
		<TR>
			<TD class="news"><xsl:value-of select="art_summary"/>
				<xsl:if test="art_img_src">
					<img width='150'>
					<xsl:attribute name="src"><xsl:value-of select="art_img_src"/></xsl:attribute>
					</img>
				</xsl:if>
			</TD>
		</TR>
		<TR><TD class="spacer"><xsl:value-of select="' '"/></TD></TR>
  </xsl:template>
  
  
</xsl:stylesheet>