import React, { useState } from 'react';
import {
  Box,
  Container,
  Typography,
  Card,
  CardContent,
  Button,
  Stack,
  Avatar,
  Badge,
  Chip,
  TextField,
  IconButton,
  List,
  ListItem,
  ListItemAvatar,
  ListItemText,
  Divider,
  Paper,
  Tab,
  Tabs,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  Menu,
  MenuItem,
  Pagination,
} from '@mui/material';
import {
  Forum as ForumIcon,
  Chat as ChatIcon,
  FolderOpen as CategoryIcon,
  Circle as OnlineIcon,
  Add as AddIcon,
  Search as SearchIcon,
  Reply as ReplyIcon,
  MoreVert as MoreVertIcon,
  Send as SendIcon,
  ThumbUp as LikeIcon,
  Visibility as ViewIcon,
} from '@mui/icons-material';
import { mockForumCategories, mockDiscussions, mockChatMessages, mockOnlineUsers } from './forumsChatMockData';

// Forum Category Card Component
const ForumCategoryCard: React.FC<{
  category: any;
  onClick: () => void;
}> = ({ category, onClick }) => (
  <Card 
    sx={{ 
      cursor: 'pointer', 
      '&:hover': { boxShadow: 3 },
      transition: 'box-shadow 0.3s'
    }}
    onClick={onClick}
  >
    <CardContent>
      <Stack direction="row" alignItems="center" spacing={2}>
        <Box
          sx={{
            width: 16,
            height: 16,
            borderRadius: '50%',
            backgroundColor: category.color,
          }}
        />
        <Box sx={{ flexGrow: 1 }}>
          <Typography variant="h6" component="h3">
            {category.name}
          </Typography>
          <Typography variant="body2" color="text.secondary">
            {category.description}
          </Typography>
        </Box>
        <Box sx={{ textAlign: 'right' }}>
          <Typography variant="body2" fontWeight="bold">
            {category.discussionCount} discussions
          </Typography>
          <Typography variant="caption" color="text.secondary">
            {category.messageCount} messages
          </Typography>
        </Box>
      </Stack>
      
      {category.lastMessage && (
        <Box sx={{ mt: 2, pt: 2, borderTop: 1, borderColor: 'divider' }}>
          <Stack direction="row" alignItems="center" spacing={1}>
            <Avatar 
              src={category.lastMessage.author.avatar} 
              sx={{ width: 24, height: 24 }} 
            />
            <Typography variant="caption" color="text.secondary">
              Dernier message par {category.lastMessage.author.name}
            </Typography>
            <Typography variant="caption" color="text.secondary" sx={{ ml: 'auto' }}>
              {new Date(category.lastMessage.createdAt).toLocaleDateString()}
            </Typography>
          </Stack>
        </Box>
      )}
    </CardContent>
  </Card>
);

// Discussion Item Component
const DiscussionItem: React.FC<{
  discussion: any;
  onClick: () => void;
}> = ({ discussion, onClick }) => (
  <Card sx={{ mb: 2, cursor: 'pointer', '&:hover': { bgcolor: 'grey.50' } }} onClick={onClick}>
    <CardContent>
      <Stack direction="row" justifyContent="space-between" alignItems="flex-start">
        <Box sx={{ flexGrow: 1 }}>
          <Stack direction="row" alignItems="center" spacing={1} sx={{ mb: 1 }}>
            {discussion.isPinned && (
              <Chip label="Épinglé" size="small" color="primary" />
            )}
            <Chip 
              label={discussion.status} 
              size="small" 
              color={discussion.status === 'open' ? 'success' : 'default'} 
            />
          </Stack>
          
          <Typography variant="h6" component="h3" sx={{ mb: 1 }}>
            {discussion.title}
          </Typography>
          
          <Stack direction="row" alignItems="center" spacing={2}>
            <Stack direction="row" alignItems="center" spacing={1}>
              <Avatar 
                src={discussion.author.avatar} 
                sx={{ width: 24, height: 24 }} 
              />
              <Typography variant="body2" color="text.secondary">
                {discussion.author.name}
              </Typography>
            </Stack>
            <Typography variant="body2" color="text.secondary">
              {new Date(discussion.createdAt).toLocaleDateString()}
            </Typography>
          </Stack>
        </Box>
        
        <Stack direction="row" spacing={3} alignItems="center">
          <Stack direction="row" alignItems="center" spacing={0.5}>
            <ReplyIcon fontSize="small" color="action" />
            <Typography variant="body2">{discussion.replyCount}</Typography>
          </Stack>
          <Stack direction="row" alignItems="center" spacing={0.5}>
            <ViewIcon fontSize="small" color="action" />
            <Typography variant="body2">{discussion.viewCount}</Typography>
          </Stack>
          <Stack direction="row" alignItems="center" spacing={0.5}>
            <LikeIcon fontSize="small" color="action" />
            <Typography variant="body2">{discussion.likeCount}</Typography>
          </Stack>
        </Stack>
      </Stack>
    </CardContent>
  </Card>
);

// Chat Message Component
const ChatMessage: React.FC<{
  message: any;
  isOwnMessage: boolean;
}> = ({ message, isOwnMessage }) => (
  <Stack 
    direction={isOwnMessage ? "row-reverse" : "row"} 
    spacing={1} 
    sx={{ mb: 2 }}
  >
    <Avatar 
      src={message.author.avatar} 
      sx={{ width: 32, height: 32 }} 
    />
    <Paper
      sx={{
        p: 2,
        maxWidth: '70%',
        bgcolor: isOwnMessage ? 'primary.main' : 'grey.100',
        color: isOwnMessage ? 'primary.contrastText' : 'text.primary',
      }}
    >
      <Typography variant="caption" sx={{ opacity: 0.8, display: 'block' }}>
        {message.author.name}
      </Typography>
      <Typography variant="body2">
        {message.content}
      </Typography>
      <Typography variant="caption" sx={{ opacity: 0.6, display: 'block', mt: 0.5 }}>
        {new Date(message.createdAt).toLocaleTimeString()}
      </Typography>
    </Paper>
  </Stack>
);

// User Status Component
const UserStatusIndicator: React.FC<{
  user: any;
  onChatClick: () => void;
}> = ({ user, onChatClick }) => (
  <ListItem>
    <ListItemAvatar>
      <Badge
        overlap="circular"
        anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }}
        badgeContent={
          <OnlineIcon 
            sx={{ 
              color: user.isOnline ? 'success.main' : 'grey.400',
              fontSize: 12 
            }} 
          />
        }
      >
        <Avatar src={user.avatar} />
      </Badge>
    </ListItemAvatar>
    <ListItemText
      primary={user.name}
      secondary={`${user.role} • ${user.isOnline ? 'En ligne' : 'Hors ligne'}`}
    />
    <IconButton onClick={onChatClick} size="small">
      <ChatIcon />
    </IconButton>
  </ListItem>
);

// Main App Component
const ForumsChatApp: React.FC = () => {
  const [currentTab, setCurrentTab] = useState(0);
  const [selectedCategory, setSelectedCategory] = useState<any>(null);
  const [selectedDiscussion, setSelectedDiscussion] = useState<any>(null);
  const [createDiscussionOpen, setCreateDiscussionOpen] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const [chatMessage, setChatMessage] = useState('');
  const [anchorEl, setAnchorEl] = useState<null | HTMLElement>(null);

  const handleTabChange = (event: React.SyntheticEvent, newValue: number) => {
    setCurrentTab(newValue);
  };

  const handleCategoryClick = (category: any) => {
    setSelectedCategory(category);
    setCurrentTab(1); // Switch to discussions tab
  };

  const handleDiscussionClick = (discussion: any) => {
    setSelectedDiscussion(discussion);
    setCurrentTab(2); // Switch to discussion detail tab
  };

  const handleSendMessage = () => {
    if (chatMessage.trim()) {
      // Handle send message logic
      console.log('Sending message:', chatMessage);
      setChatMessage('');
    }
  };

  const handleMenuClick = (event: React.MouseEvent<HTMLElement>) => {
    setAnchorEl(event.currentTarget);
  };

  const handleMenuClose = () => {
    setAnchorEl(null);
  };

  return (
    <Container maxWidth="lg" sx={{ py: 4 }}>
      <Typography variant="h3" component="h1" gutterBottom>
        Forums & Chat - Système LMS
      </Typography>

      <Box sx={{ borderBottom: 1, borderColor: 'divider', mb: 3 }}>
        <Tabs value={currentTab} onChange={handleTabChange}>
          <Tab label="Dashboard Forums" icon={<ForumIcon />} />
          <Tab label="Discussions" icon={<ForumIcon />} />
          <Tab label="Discussion Détail" icon={<ReplyIcon />} />
          <Tab label="Chat" icon={<ChatIcon />} />
        </Tabs>
      </Box>

      {/* Dashboard Forums */}
      {currentTab === 0 && (
        <Stack spacing={4}>
          {/* Stats Cards */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={2}>
            <Card sx={{ flex: 1 }}>
              <CardContent>
                <Stack direction="row" alignItems="center" spacing={2}>
                  <Box sx={{ p: 1, bgcolor: 'primary.light', borderRadius: 2 }}>
                    <ForumIcon color="primary" />
                  </Box>
                  <Box>
                    <Typography variant="h6">Discussions</Typography>
                    <Typography variant="h4" color="primary">
                      {mockDiscussions.length}
                    </Typography>
                  </Box>
                </Stack>
              </CardContent>
            </Card>
            
            <Card sx={{ flex: 1 }}>
              <CardContent>
                <Stack direction="row" alignItems="center" spacing={2}>
                  <Box sx={{ p: 1, bgcolor: 'success.light', borderRadius: 2 }}>
                    <CategoryIcon color="success" />
                  </Box>
                  <Box>
                    <Typography variant="h6">Catégories</Typography>
                    <Typography variant="h4" color="success.main">
                      {mockForumCategories.length}
                    </Typography>
                  </Box>
                </Stack>
              </CardContent>
            </Card>
          </Stack>

          {/* Action Buttons */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={2}>
            <Button
              variant="contained"
              startIcon={<AddIcon />}
              onClick={() => setCreateDiscussionOpen(true)}
            >
              Nouvelle Discussion
            </Button>
            <Button variant="outlined" startIcon={<SearchIcon />}>
              Rechercher
            </Button>
          </Stack>

          {/* Categories */}
          <Box>
            <Typography variant="h5" gutterBottom>
              Catégories de Forums
            </Typography>
            <Stack spacing={2}>
              {mockForumCategories.map((category) => (
                <ForumCategoryCard
                  key={category.id}
                  category={category}
                  onClick={() => handleCategoryClick(category)}
                />
              ))}
            </Stack>
          </Box>
        </Stack>
      )}

      {/* Discussions List */}
      {currentTab === 1 && (
        <Stack spacing={3}>
          <Stack direction="row" justifyContent="space-between" alignItems="center">
            <Typography variant="h5">
              {selectedCategory ? `Discussions - ${selectedCategory.name}` : 'Toutes les Discussions'}
            </Typography>
            <Button
              variant="contained"
              startIcon={<AddIcon />}
              onClick={() => setCreateDiscussionOpen(true)}
            >
              Nouvelle Discussion
            </Button>
          </Stack>

          {/* Search and Filters */}
          <Paper sx={{ p: 2 }}>
            <Stack direction={{ xs: 'column', md: 'row' }} spacing={2}>
              <TextField
                placeholder="Rechercher des discussions..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                InputProps={{
                  startAdornment: <SearchIcon sx={{ mr: 1, color: 'action.active' }} />,
                }}
                sx={{ flex: 1 }}
              />
              <Button variant="outlined">Filtrer</Button>
            </Stack>
          </Paper>

          {/* Discussions */}
          <Box>
            {mockDiscussions.map((discussion) => (
              <DiscussionItem
                key={discussion.id}
                discussion={discussion}
                onClick={() => handleDiscussionClick(discussion)}
              />
            ))}
          </Box>

          {/* Pagination */}
          <Box sx={{ display: 'flex', justifyContent: 'center' }}>
            <Pagination count={3} color="primary" />
          </Box>
        </Stack>
      )}

      {/* Discussion Detail */}
      {currentTab === 2 && selectedDiscussion && (
        <Stack spacing={3}>
          <Card>
            <CardContent>
              <Stack direction="row" justifyContent="space-between" alignItems="flex-start">
                <Box sx={{ flex: 1 }}>
                  <Stack direction="row" alignItems="center" spacing={1} sx={{ mb: 2 }}>
                    {selectedDiscussion.isPinned && (
                      <Chip label="Épinglé" size="small" color="primary" />
                    )}
                    <Chip 
                      label={selectedDiscussion.status} 
                      size="small" 
                      color={selectedDiscussion.status === 'open' ? 'success' : 'default'} 
                    />
                  </Stack>
                  
                  <Typography variant="h4" gutterBottom>
                    {selectedDiscussion.title}
                  </Typography>
                  
                  <Stack direction="row" alignItems="center" spacing={2} sx={{ mb: 3 }}>
                    <Avatar src={selectedDiscussion.author.avatar} />
                    <Box>
                      <Typography variant="body1" fontWeight="bold">
                        {selectedDiscussion.author.name}
                      </Typography>
                      <Typography variant="body2" color="text.secondary">
                        {new Date(selectedDiscussion.createdAt).toLocaleString()}
                      </Typography>
                    </Box>
                  </Stack>
                  
                  <Typography variant="body1" paragraph>
                    {selectedDiscussion.content}
                  </Typography>
                </Box>
                
                <IconButton onClick={handleMenuClick}>
                  <MoreVertIcon />
                </IconButton>
              </Stack>
            </CardContent>
          </Card>

          {/* Reply Form */}
          <Card>
            <CardContent>
              <Typography variant="h6" gutterBottom>
                Répondre à la discussion
              </Typography>
              <TextField
                multiline
                rows={4}
                placeholder="Écrivez votre réponse..."
                fullWidth
                sx={{ mb: 2 }}
              />
              <Button variant="contained" startIcon={<ReplyIcon />}>
                Répondre
              </Button>
            </CardContent>
          </Card>
        </Stack>
      )}

      {/* Chat */}
      {currentTab === 3 && (
        <Stack direction={{ xs: 'column', lg: 'row' }} spacing={3}>
          {/* Chat Area */}
          <Paper sx={{ flex: 2, height: 600, display: 'flex', flexDirection: 'column' }}>
            <Box sx={{ p: 2, borderBottom: 1, borderColor: 'divider' }}>
              <Typography variant="h6">Chat Global</Typography>
            </Box>
            
            <Box sx={{ flex: 1, overflow: 'auto', p: 2 }}>
              {mockChatMessages.map((message) => (
                <ChatMessage
                  key={message.id}
                  message={message}
                  isOwnMessage={message.authorId === 1} // Mock current user ID
                />
              ))}
            </Box>
            
            <Box sx={{ p: 2, borderTop: 1, borderColor: 'divider' }}>
              <Stack direction="row" spacing={1}>
                <TextField
                  placeholder="Tapez votre message..."
                  value={chatMessage}
                  onChange={(e) => setChatMessage(e.target.value)}
                  onKeyPress={(e) => e.key === 'Enter' && handleSendMessage()}
                  fullWidth
                  size="small"
                />
                <IconButton onClick={handleSendMessage} color="primary">
                  <SendIcon />
                </IconButton>
              </Stack>
            </Box>
          </Paper>

          {/* Users Sidebar */}
          <Paper sx={{ flex: 1, height: 600, overflow: 'auto' }}>
            <Box sx={{ p: 2, borderBottom: 1, borderColor: 'divider' }}>
              <Typography variant="h6">Utilisateurs en ligne</Typography>
            </Box>
            
            <List>
              {mockOnlineUsers.map((user) => (
                <React.Fragment key={user.id}>
                  <UserStatusIndicator
                    user={user}
                    onChatClick={() => console.log('Start chat with', user.name)}
                  />
                  <Divider />
                </React.Fragment>
              ))}
            </List>
          </Paper>
        </Stack>
      )}

      {/* Create Discussion Dialog */}
      <Dialog 
        open={createDiscussionOpen} 
        onClose={() => setCreateDiscussionOpen(false)}
        maxWidth="md"
        fullWidth
      >
        <DialogTitle>Créer une nouvelle discussion</DialogTitle>
        <DialogContent>
          <Stack spacing={3} sx={{ mt: 1 }}>
            <TextField
              label="Titre de la discussion"
              fullWidth
              required
            />
            <TextField
              label="Catégorie"
              select
              fullWidth
              required
              defaultValue=""
            >
              {mockForumCategories.map((category) => (
                <MenuItem key={category.id} value={category.id}>
                  {category.name}
                </MenuItem>
              ))}
            </TextField>
            <TextField
              label="Contenu"
              multiline
              rows={6}
              fullWidth
              required
            />
          </Stack>
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setCreateDiscussionOpen(false)}>
            Annuler
          </Button>
          <Button variant="contained" onClick={() => setCreateDiscussionOpen(false)}>
            Créer Discussion
          </Button>
        </DialogActions>
      </Dialog>

      {/* Context Menu */}
      <Menu
        anchorEl={anchorEl}
        open={Boolean(anchorEl)}
        onClose={handleMenuClose}
      >
        <MenuItem onClick={handleMenuClose}>Épingler</MenuItem>
        <MenuItem onClick={handleMenuClose}>Fermer</MenuItem>
        <MenuItem onClick={handleMenuClose}>Signaler</MenuItem>
      </Menu>
    </Container>
  );
};

export default ForumsChatApp;