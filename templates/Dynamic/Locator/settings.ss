{
  "radii": <% if $ShowRadius %>
    [<% loop $Radii %>$Radius<% if not $Last %>,<% end_if %><% end_loop %>]
  <% else %>
    []
  <% end_if %>,
  <% if $Categories %>"categories": [<% loop $Categories %>
    {
      "ID": $ID,
      "Name": "$Name"
    }<% if not $Last %>,<% end_if %><% end_loop %>
  ],<% end_if %>
  "unit": "$Unit",
  "limit": $Limit,
  "clusters": $Clusters,
  "infoWindowTemplate": $InfoWindowTemplate.RAW,
  "listTemplate": $ListTemplate.RAW
}