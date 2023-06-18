# House

| col                | type     | desc                                 | attr      |
| ------------------ | -------- | ------------------------------------ | --------- |
| id                 | int      |                                      |           |
| name               | string   | name of house                        |           |
| owner_id           | int      | fk of owner                          |           |
| price              | int      | rent price per month                 |           |
| size               | decimal  | area of house                        | nullable  |
| shortest_rent_time | enum     | 一個月～三年的選項                   |           |
| house_type_id      | int      | fk of house_type: 套房、雅房、辦公等 |           |
| description        | longText | description of house                 | nullable  |
| city_id            | int      | fk of city                           |           |
| city_dist_id       | int      | fk of city dist                      | nullable  |
| address            | string   | full address                         | nullable  |
| can_cook           | boolean  | 可開伙                               | default F |
| can_pet            | boolean  | 可養寵物                             | default F |
| near_stop          | boolean  | 近捷運、車站                         | default F |
| has_parking        | boolean  | 含車位                               | default F |
| has_elevator       | boolean  | 有電梯                               | default F |
| timestamps         |
| softdeletes        |

