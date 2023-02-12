<xsl:stylesheet version="2.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<div>Articles</div>
        <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" class="MainTable2">
			<xsl:apply-templates  select="//articel_detail" />
		</TABLE>
  </xsl:template>
  <xsl:template match="articel_detail">
    <TR><TH class="newsHeader2"><xsl:value-of select="art_headline"/></TH></TR>
	<TR><TD class="news2">
		 <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0">
		 	<TR>
		 		<TD>
			 		<xsl:if test="art_img_src">
						<img width='150'>
							<xsl:attribute name="src">
								<xsl:value-of select="art_img_src"/>
							</xsl:attribute>
						</img>
					</xsl:if>
				</TD>
		 		<TD><xsl:value-of select="art_summary"/></TD>
		 	</TR>
		 </TABLE>
	</TD></TR>
	<TR><TD class="spacer"><xsl:value-of select="' '"/></TD></TR>
  </xsl:template>
</xsl:stylesheet>